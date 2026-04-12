<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $activeLoans = $user->loans()->active()->count();
        $totalLoanDebt = $user->loans()->active()->get()->sum('remaining');
        $currentDebts = $user->debts()->current()->count();
        $totalDebtAmount = $user->debts()->current()->get()->sum('remaining');
        $activeSavingGroups = $user->savingGroups()->active()->count();
        $recentPayments = $user->payments()->with('payable')->latest()->take(5)->get();

        return view('dashboard', compact(
            'user',
            'activeLoans',
            'totalLoanDebt',
            'currentDebts',
            'totalDebtAmount',
            'activeSavingGroups',
            'recentPayments'
        ));
    }
}
