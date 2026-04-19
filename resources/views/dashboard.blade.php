<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">Dashboard</h2>
        <p class="text-sm text-slate-400 mt-1">Welcome back, {{ Auth::user()->name }}!</p>
    </x-slot>

    <!-- Balance Card -->
    <div class="mb-8">
        <div class="rounded-2xl bg-zinc-900 border border-zinc-800/50 p-8">
            <div class="relative">
                <p class="text-zinc-400 text-sm font-medium mb-1">Available Balance</p>
                <p class="text-4xl lg:text-5xl font-bold text-white tracking-tight">${{ number_format($user->balance, 2) }}</p>
                <div class="mt-6 flex flex-wrap items-center gap-4">
                    <a href="{{ route('loans.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-zinc-200 rounded-xl text-sm font-medium text-zinc-900 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Borrow
                    </a>
                    <a href="{{ route('debts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-800 hover:bg-zinc-700 rounded-xl text-sm font-medium text-white transition-colors border border-zinc-700/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                        Add Debt
                    </a>
                    <form method="POST" action="{{ route('hack.add-money') }}" class="inline-flex items-center gap-2 ml-auto">
                        @csrf
                        <input type="number" name="amount" value="1000" min="1" step="0.01" class="w-24 px-3 py-2 bg-zinc-950 border border-zinc-800 rounded-xl text-white text-sm focus:outline-none focus:border-zinc-600" placeholder="Amount">
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-800 hover:bg-zinc-700 rounded-xl text-sm font-medium text-white transition-colors border border-zinc-700/50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Add
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Active Loans -->
        <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6 hover:border-zinc-700 transition-colors group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-zinc-800 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <a href="{{ route('loans.index') }}" class="text-xs text-zinc-500 hover:text-white transition-colors">View all →</a>
            </div>
            <p class="text-3xl font-bold text-white">{{ $activeLoans }}</p>
            <p class="text-sm text-zinc-400 mt-1">Active Loans</p>
            <p class="text-xs text-zinc-500 mt-2">${{ number_format($totalLoanDebt, 2) }} total owed</p>
        </div>

        <!-- Current Debts -->
        <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6 hover:border-zinc-700 transition-colors group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-zinc-800 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                </div>
                <a href="{{ route('debts.index') }}" class="text-xs text-zinc-500 hover:text-white transition-colors">View all →</a>
            </div>
            <p class="text-3xl font-bold text-white">{{ $currentDebts }}</p>
            <p class="text-sm text-zinc-400 mt-1">Current Debts</p>
            <p class="text-xs text-zinc-500 mt-2">${{ number_format($totalDebtAmount, 2) }} remaining</p>
        </div>

        <!-- Saving Groups -->
        <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6 hover:border-zinc-700 transition-colors group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-zinc-800 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <a href="{{ route('saving-groups.index') }}" class="text-xs text-zinc-500 hover:text-white transition-colors">View all →</a>
            </div>
            <p class="text-3xl font-bold text-white">{{ $activeSavingGroups }}</p>
            <p class="text-sm text-zinc-400 mt-1">Active Saving Groups</p>
            <p class="text-xs text-zinc-500 mt-2">Rotating monthly payouts</p>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-zinc-800/50">
            <h3 class="text-lg font-semibold text-white">Recent Payments</h3>
        </div>
        @if($recentPayments->count() > 0)
            <div class="divide-y divide-zinc-800/50">
                @foreach($recentPayments as $payment)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-zinc-800/30 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-zinc-800">
                                @if($payment->payable_type === 'App\\Models\\Loan')
                                    <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                @else
                                    <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white">{{ $payment->payable_type === 'App\\Models\\Loan' ? 'Loan Payment' : 'Debt Payment' }}</p>
                                <p class="text-xs text-zinc-500">{{ $payment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-zinc-300">-${{ number_format($payment->amount, 2) }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="w-12 h-12 text-zinc-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <p class="text-zinc-500 text-sm">No payments yet</p>
                <p class="text-zinc-600 text-xs mt-1">Your payment history will appear here</p>
            </div>
        @endif
    </div>
</x-app-layout>
