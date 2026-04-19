<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('debts.index') }}" class="text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-white">Add New Debt</h2>
                <p class="text-sm text-slate-400 mt-1">Record a debt to track and pay off</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-lg mx-auto">
        <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6">
            <form method="POST" action="{{ route('debts.store') }}">
                @csrf
                <div class="mb-5">
                    <label for="description" class="block text-sm font-medium text-zinc-400 mb-2">Description</label>
                    <input type="text" name="description" id="description" value="{{ old('description') }}" required
                        class="w-full px-4 py-3 bg-zinc-950 border border-zinc-800 rounded-xl text-white placeholder-zinc-600 focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all duration-200"
                        placeholder="e.g., Car repair, Medical bill, etc.">
                    @error('description')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="amount" class="block text-sm font-medium text-zinc-400 mb-2">Amount ($)</label>
                    <input type="number" name="amount" id="amount" step="0.01" min="1" value="{{ old('amount') }}" required
                        class="w-full px-4 py-3 bg-zinc-950 border border-zinc-800 rounded-xl text-white placeholder-zinc-600 focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all duration-200"
                        placeholder="Enter debt amount">
                    @error('amount')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full px-6 py-3 bg-white hover:bg-zinc-200 text-zinc-900 font-semibold rounded-xl transition-all duration-200">
                    Record Debt
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
