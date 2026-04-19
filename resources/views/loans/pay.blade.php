<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('loans.index') }}" class="text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-white">Pay Loan #{{ $loan->id }}</h2>
                <p class="text-sm text-slate-400 mt-1">Make a payment towards your loan</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-lg mx-auto">
        <!-- Loan Details -->
        <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6 mb-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-zinc-500">Borrowed</p>
                    <p class="text-lg font-semibold text-white">${{ number_format($loan->amount, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-zinc-500">Interest (5%)</p>
                    <p class="text-lg font-semibold text-white">${{ number_format($loan->interest, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-zinc-500">Total Due</p>
                    <p class="text-lg font-semibold text-white">${{ number_format($loan->total_due, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-zinc-500">Already Paid</p>
                    <p class="text-lg font-semibold text-emerald-400">${{ number_format($loan->amount_paid, 2) }}</p>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-zinc-800/50">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-zinc-400">Remaining Balance</p>
                    <p class="text-2xl font-bold text-amber-400">${{ number_format($loan->remaining, 2) }}</p>
                </div>
                <div class="w-full h-2 bg-zinc-800 rounded-full mt-3">
                    <div class="h-full bg-white rounded-full transition-all duration-500" style="width: {{ $loan->total_due > 0 ? ($loan->amount_paid / $loan->total_due) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6">
            <form method="POST" action="{{ route('loans.pay.store', $loan) }}">
                @csrf
                <div class="mb-6">
                    <label for="amount" class="block text-sm font-medium text-zinc-400 mb-2">Payment Amount ($)</label>
                    <input type="number" name="amount" id="amount" step="0.01" min="5" max="{{ $loan->remaining }}" value="{{ old('amount') }}" required
                        class="w-full px-4 py-3 bg-zinc-950 border border-zinc-800 rounded-xl text-white placeholder-zinc-600 focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all duration-200"
                        placeholder="Min $5.00 — Max ${{ number_format($loan->remaining, 2) }}">
                    @error('amount')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-zinc-500">Your balance: ${{ number_format(Auth::user()->balance, 2) }}</p>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="flex-1 px-6 py-3 bg-white hover:bg-zinc-200 text-zinc-900 font-semibold rounded-xl transition-all duration-200">
                        Make Payment
                    </button>
                    <a href="{{ route('loans.index') }}" class="px-6 py-3 bg-zinc-800 hover:bg-zinc-700 text-white font-medium rounded-xl transition-all duration-200 text-center border border-zinc-700/50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
