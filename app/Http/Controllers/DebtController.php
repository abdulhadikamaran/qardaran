<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DebtController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentDebts = $user->debts()->current()->latest()->get();
        $paidDebts = $user->debts()->paid()->latest()->get();

        return view('debts.index', compact('currentDebts', 'paidDebts', 'user'));
    }

    public function create()
    {
        return view('debts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $amount = round($request->amount, 2);

        DB::transaction(function () use ($request, $amount) {
            $user = Auth::user();
            $user->increment('balance', $amount);

            Debt::create([
                'user_id' => $user->id,
                'description' => $request->description,
                'amount' => $amount,
            ]);
        });

        return redirect()->route('debts.index')->with('success', 'Debt recorded successfully.');
    }

    public function show(Debt $debt)
    {
        $this->authorizeDebt($debt);
        // Load the payments for the timeline
        $debt->load('payments');

        return view('debts.show', compact('debt'));
    }

    public function showPayForm(Debt $debt)
    {
        $this->authorizeDebt($debt);

        if ($debt->status === 'paid') {
            return redirect()->route('debts.index')->with('error', 'This debt is already paid off.');
        }

        return view('debts.pay', compact('debt'));
    }

    public function pay(Request $request, Debt $debt)
    {
        $this->authorizeDebt($debt);

        if ($debt->status === 'paid') {
            return redirect()->route('debts.index')->with('error', 'This debt is already paid off.');
        }

        $remaining = $debt->remaining;

        $request->validate([
            'amount' => ['required', 'numeric', 'min:5', 'max:' . $remaining],
        ]);

        $user = Auth::user();
        $payAmount = round($request->amount, 2);

        if ($payAmount > $user->balance) {
            return back()->withErrors(['amount' => 'Insufficient balance.']);
        }

        DB::transaction(function () use ($user, $debt, $payAmount) {
            $user->decrement('balance', $payAmount);
            $debt->increment('amount_paid', $payAmount);

            Payment::create([
                'user_id' => $user->id,
                'payable_type' => Debt::class,
                'payable_id' => $debt->id,
                'amount' => $payAmount,
            ]);

            $debt->refresh();
            if ($debt->remaining <= 0) {
                $debt->update(['status' => 'paid']);
            }
        });

        return redirect()->route('debts.index')->with('success', "Payment of $$payAmount applied to debt.");
    }

    public function destroy(Debt $debt)
    {
        $this->authorizeDebt($debt);

        if ($debt->status !== 'paid') {
            return redirect()->route('debts.index')->with('error', 'You can only delete paid (old) debts.');
        }

        $debt->delete();

        return redirect()->route('debts.index')->with('success', 'Old debt record removed.');
    }

    private function authorizeDebt(Debt $debt): void
    {
        if ($debt->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
