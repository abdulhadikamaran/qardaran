<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('saving-groups.index') }}" class="text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-white">Create Saving Group</h2>
                <p class="text-sm text-slate-400 mt-1">Set up a new community saving circle</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-lg mx-auto">
        <!-- Info Card -->
        <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6 mb-6">
            <h3 class="text-sm font-semibold text-zinc-300 mb-2 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                How it works
            </h3>
            <p class="text-sm text-zinc-400">Each participant contributes a fixed amount monthly. Each round, one random participant wins the entire pool. Every participant wins exactly once.</p>
        </div>

        <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6">
            <form method="POST" action="{{ route('saving-groups.store') }}">
                @csrf
                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium text-zinc-400 mb-2">Group Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 bg-zinc-950 border border-zinc-800 rounded-xl text-white placeholder-zinc-600 focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all duration-200"
                        placeholder="e.g., Family Savings, Office Pool">
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="num_participants" class="block text-sm font-medium text-zinc-400 mb-2">Number of Participants</label>
                    <input type="number" name="num_participants" id="num_participants" min="2" max="20" value="{{ old('num_participants', 5) }}" required
                        class="w-full px-4 py-3 bg-zinc-950 border border-zinc-800 rounded-xl text-white placeholder-zinc-600 focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all duration-200"
                        placeholder="2 - 20 participants">
                    @error('num_participants')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="contribution_amount" class="block text-sm font-medium text-zinc-400 mb-2">Monthly Contribution ($)</label>
                    <input type="number" name="contribution_amount" id="contribution_amount" step="0.01" min="10" value="{{ old('contribution_amount', 100) }}" required
                        class="w-full px-4 py-3 bg-zinc-950 border border-zinc-800 rounded-xl text-white placeholder-zinc-600 focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all duration-200"
                        placeholder="Amount per person per month">
                    @error('contribution_amount')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full px-6 py-3 bg-white hover:bg-zinc-200 text-zinc-900 font-semibold rounded-xl transition-all duration-200">
                    Create Group
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
