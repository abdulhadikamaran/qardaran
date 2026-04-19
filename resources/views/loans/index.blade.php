<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white">Loans</h2>
                <p class="text-sm text-slate-400 mt-1">Manage your borrowed funds</p>
            </div>
            <a href="{{ route('loans.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white hover:bg-zinc-200 text-zinc-900 text-sm font-medium rounded-xl transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Borrow Money
            </a>
        </div>
    </x-slot>

    <!-- Active Loans -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
            Active Loans ({{ $activeLoans->count() }}/3)
        </h3>
        @if($activeLoans->count() > 0)
            <div class="grid gap-4">
                @foreach($activeLoans as $loan)
                    <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6 hover:border-zinc-700 transition-all duration-300">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-white font-semibold">Loan #{{ $loan->id }}</p>
                                    <p class="text-xs text-slate-500">Borrowed: ${{ number_format($loan->amount, 2) }} · Interest: ${{ number_format($loan->interest, 2) }} (5%)</p>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $loan->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 sm:gap-6">
                                <div class="text-right">
                                    <p class="text-xs text-slate-500">Remaining</p>
                                    <p class="text-lg font-bold text-amber-400">${{ number_format($loan->remaining, 2) }}</p>
                                    <!-- Progress bar -->
                                    <div class="w-32 h-1.5 bg-zinc-800 rounded-full mt-1">
                                        <div class="h-full bg-white rounded-full transition-all duration-500" style="width: {{ $loan->total_due > 0 ? ($loan->amount_paid / $loan->total_due) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                                <a href="{{ route('loans.pay', $loan) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-white text-sm font-medium rounded-xl border border-zinc-700/50 transition-all duration-200">
                                    Pay
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-12 text-center">
                <svg class="w-12 h-12 text-zinc-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-zinc-400 font-medium">No active loans</p>
                <p class="text-zinc-600 text-sm mt-1">You're debt-free! Need to borrow?</p>
            </div>
        @endif
    </div>

    <!-- Paid Loans History -->
    @if($paidLoans->count() > 0)
        <div>
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Paid Off ({{ $paidLoans->count() }})
            </h3>
            <div class="grid gap-3">
                @foreach($paidLoans as $loan)
                    <a href="{{ route('loans.show', $loan) }}" class="block bg-zinc-900 border border-zinc-800/50 rounded-xl p-4 hover:bg-zinc-800 transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-zinc-800 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <p class="text-zinc-300 text-sm font-medium">Loan #{{ $loan->id }} — ${{ number_format($loan->total_due, 2) }}</p>
                                    <p class="text-xs text-zinc-500">Paid · {{ $loan->updated_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-emerald-500 font-medium bg-emerald-500/10 px-2.5 py-1 rounded-full border border-emerald-500/20">PAID</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</x-app-layout>
