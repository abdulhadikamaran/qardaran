<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('loans.index') }}" class="text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-white">Loan Details</h2>
                <p class="text-sm text-slate-400 mt-1">Loan #{{ $loan->id }} overview</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Details Card -->
        <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <p class="text-sm text-zinc-400">Total Borrowed</p>
                    <p class="text-3xl font-bold text-white">${{ number_format($loan->amount, 2) }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-2.5 py-1 border rounded-full text-xs font-medium {{ $loan->status === 'paid' ? 'bg-zinc-800 border-zinc-700 text-emerald-400' : 'bg-zinc-800 border-zinc-700 text-amber-400' }}">
                        {{ strtoupper($loan->status) }}
                    </span>
                    <p class="text-sm text-zinc-400 mt-2">Interest (5%): ${{ number_format($loan->interest, 2) }}</p>
                    <p class="text-sm text-white font-medium">Total Due: ${{ number_format($loan->total_due, 2) }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-zinc-800/50">
                <div>
                    <p class="text-xs text-zinc-500">Amount Paid</p>
                    <p class="text-lg font-semibold text-emerald-400">${{ number_format($loan->amount_paid, 2) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-zinc-500">Remaining Balance</p>
                    <p class="text-lg font-semibold text-amber-400">${{ number_format($loan->remaining, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Payments Timeline -->
        <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Payment History</h3>
            
            @if($loan->payments->count() > 0)
                <div class="space-y-4">
                    @foreach($loan->payments as $payment)
                        <div class="flex items-center justify-between p-4 bg-zinc-950 rounded-xl border border-zinc-800">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-zinc-800 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-white">Payment Received</p>
                                    <p class="text-xs text-zinc-500">{{ $payment->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            <span class="text-emerald-400 font-semibold">+${{ number_format($payment->amount, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <p class="text-zinc-500 text-sm">No payments have been made yet.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
