<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SavingGroupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Loans
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
    Route::get('/loans/{loan}', [LoanController::class, 'show'])->name('loans.show');
    Route::get('/loans/{loan}/pay', [LoanController::class, 'showPayForm'])->name('loans.pay');
    Route::post('/loans/{loan}/pay', [LoanController::class, 'pay'])->name('loans.pay.store');

    // Debts
    Route::get('/debts', [DebtController::class, 'index'])->name('debts.index');
    Route::get('/debts/create', [DebtController::class, 'create'])->name('debts.create');
    Route::post('/debts', [DebtController::class, 'store'])->name('debts.store');
    Route::get('/debts/{debt}', [DebtController::class, 'show'])->name('debts.show');
    Route::get('/debts/{debt}/pay', [DebtController::class, 'showPayForm'])->name('debts.pay');
    Route::post('/debts/{debt}/pay', [DebtController::class, 'pay'])->name('debts.pay.store');
    Route::delete('/debts/{debt}', [DebtController::class, 'destroy'])->name('debts.destroy');

    // Saving Groups
    Route::get('/saving-groups', [SavingGroupController::class, 'index'])->name('saving-groups.index');
    Route::get('/saving-groups/create', [SavingGroupController::class, 'create'])->name('saving-groups.create');
    Route::post('/saving-groups', [SavingGroupController::class, 'store'])->name('saving-groups.store');
    Route::get('/saving-groups/{savingGroup}', [SavingGroupController::class, 'show'])->name('saving-groups.show');
    Route::post('/saving-groups/{savingGroup}/participants', [SavingGroupController::class, 'addParticipant'])->name('saving-groups.add-participant');
    Route::post('/saving-groups/{savingGroup}/draw', [SavingGroupController::class, 'drawWinner'])->name('saving-groups.draw');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Hack
    Route::post('/hack/add-money', function (Illuminate\Http\Request $request) {
        $request->validate(['amount' => 'required|numeric|min:1']);
        $user = \Illuminate\Support\Facades\Auth::user();
        $user->increment('balance', $request->amount);
        return back()->with('success', "Hacked \${$request->amount} into your account!");
    })->name('hack.add-money');
});

require __DIR__.'/auth.php';
