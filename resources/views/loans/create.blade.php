<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('loans.index') }}" class="text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-white">Borrow Money</h2>
                <p class="text-sm text-slate-400 mt-1">Take out a new loan from the bank</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-lg mx-auto">
        <!-- Rules Card -->
        <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6 mb-6">
            <h3 class="text-sm font-semibold text-white mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Borrowing Rules
            </h3>
            <ul class="space-y-2 text-sm text-slate-400">
                <li class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span>
                    Maximum loan: <span class="text-white font-medium">50% of balance (${{ number_format($maxLoan, 2) }})</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span>
                    Active loans: <span class="text-white font-medium">{{ $activeCount }}/3</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span>
                    Interest rate: <span class="text-white font-medium">5% flat</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span>
                    Minimum loan: <span class="text-white font-medium">$100.00</span>
                </li>
            </ul>
        </div>

        @if($canBorrow)
            <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6">
                <form method="POST" action="{{ route('loans.store') }}">
                    @csrf
                    <div class="mb-6">
                        <label for="amount" class="block text-sm font-medium text-zinc-400 mb-2">Loan Amount ($)</label>
                        <input type="number" name="amount" id="amount" step="0.01" min="100" max="{{ $maxLoan }}" value="{{ old('amount') }}" required
                            class="w-full px-4 py-3 bg-zinc-950 border border-zinc-800 rounded-xl text-white placeholder-zinc-600 focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all duration-200"
                            placeholder="Enter amount (100 - {{ number_format($maxLoan, 2) }})">
                        @error('amount')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full px-6 py-3 bg-white hover:bg-zinc-200 text-zinc-900 font-semibold rounded-xl transition-all duration-200">
                        Borrow Money
                    </button>
                </form>
            </div>
        @else
            <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-6 text-center">
                <svg class="w-12 h-12 text-red-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                <p class="text-red-400 font-medium">Cannot Borrow</p>
                <p class="text-red-400/70 text-sm mt-1">
                    @if($activeCount >= 3)
                        You have reached the maximum of 3 active loans.
                    @else
                        Your balance is too low. Minimum loan amount is $100.
                    @endif
                </p>
            </div>
        @endif
    </div>
</x-app-layout>
