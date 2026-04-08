<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $activeLoans = $user->loans()->active()->latest()->get();
        $paidLoans = $user->loans()->paid()->latest()->get();

        return view('loans.index', compact('activeLoans', 'paidLoans', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $maxLoan = floor($user->balance * 0.5 * 100) / 100;
        $activeCount = $user->loans()->active()->count();
        $canBorrow = $activeCount < 3 && $maxLoan >= 100;

        return view('loans.create', compact('user', 'maxLoan', 'activeCount', 'canBorrow'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $maxLoan = floor($user->balance * 0.5 * 100) / 100;
        $activeCount = $user->loans()->active()->count();

        if ($activeCount >= 3) {
            return back()->withErrors(['amount' => 'You already have 3 active loans. Pay one off first.']);
        }

        if ($maxLoan < 100) {
            return back()->withErrors(['amount' => 'Your balance is too low to borrow. Minimum loan is $100.']);
        }

        $request->validate([
            'amount' => ['required', 'numeric', 'min:100', 'max:' . $maxLoan],
        ]);

        $amount = round($request->amount, 2);
        $interest = round($amount * 0.05, 2);
        $totalDue = $amount + $interest;

        DB::transaction(function () use ($user, $amount, $interest, $totalDue) {
            $user->increment('balance', $amount);

            Loan::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'interest' => $interest,
                'total_due' => $totalDue,
            ]);
        });

        return redirect()->route('loans.index')->with('success', "Borrowed $$amount successfully! Total due: $$totalDue (incl. 5% interest).");
    }

    public function show(Loan $loan)
    {
        $this->authorize($loan);
        // Load the payments for the timeline
        $loan->load('payments');

        return view('loans.show', compact('loan'));
    }

    public function showPayForm(Loan $loan)
    {
        $this->authorize($loan);

        if ($loan->status === 'paid') {
            return redirect()->route('loans.index')->with('error', 'This loan is already paid off.');
        }

        return view('loans.pay', compact('loan'));
    }

    public function pay(Request $request, Loan $loan)
    {
        $this->authorize($loan);

        if ($loan->status === 'paid') {
            return redirect()->route('loans.index')->with('error', 'This loan is already paid off.');
        }

        $remaining = $loan->remaining;

        $request->validate([
            'amount' => ['required', 'numeric', 'min:5', 'max:' . $remaining],
        ]);

        $user = Auth::user();
        $payAmount = round($request->amount, 2);

        if ($payAmount > $user->balance) {
            return back()->withErrors(['amount' => 'Insufficient balance.']);
        }

        DB::transaction(function () use ($user, $loan, $payAmount) {
            $user->decrement('balance', $payAmount);
            $loan->increment('amount_paid', $payAmount);

            Payment::create([
                'user_id' => $user->id,
                'payable_type' => Loan::class,
                'payable_id' => $loan->id,
                'amount' => $payAmount,
            ]);

            $loan->refresh();
            if ($loan->remaining <= 0) {
                $loan->update(['status' => 'paid']);
            }
        });

        return redirect()->route('loans.index')->with('success', "Payment of $$payAmount applied to loan.");
    }

    private function authorize(Loan $loan): void
    {
        if ($loan->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
