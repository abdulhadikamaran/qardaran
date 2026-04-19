<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('saving-groups.index') }}" class="text-zinc-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-white">{{ $savingGroup->name }}</h2>
                <p class="text-sm text-zinc-400 mt-1">
                    {{ $savingGroup->num_participants }} participants · ${{ number_format($savingGroup->contribution_amount, 2) }}/month ·
                    <span class="{{ $savingGroup->status === 'active' ? 'text-violet-400' : 'text-emerald-400' }}">{{ ucfirst($savingGroup->status) }}</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Main Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Stats Bar -->
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-zinc-900 border border-zinc-800/50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-white">{{ $savingGroup->current_round }}</p>
                    <p class="text-xs text-zinc-500 mt-1">Current Round</p>
                </div>
                <div class="bg-zinc-900 border border-zinc-800/50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-violet-400">${{ number_format($savingGroup->monthly_pool, 2) }}</p>
                    <p class="text-xs text-zinc-500 mt-1">Monthly Pool</p>
                </div>
                <div class="bg-zinc-900 border border-zinc-800/50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-white">{{ $participantsAdded }}/{{ $savingGroup->num_participants }}</p>
                    <p class="text-xs text-zinc-500 mt-1">Participants</p>
                </div>
            </div>

            <!-- Progress -->
            <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6">
                <h3 class="text-sm font-semibold text-white mb-3">Group Progress</h3>
                <div class="w-full h-3 bg-zinc-800 rounded-full">
                    <div class="h-full bg-white rounded-full transition-all duration-500" style="width: {{ $savingGroup->num_participants > 0 ? ($savingGroup->current_round / $savingGroup->num_participants) * 100 : 0 }}%"></div>
                </div>
                <p class="text-xs text-zinc-500 mt-2">{{ $savingGroup->current_round }} of {{ $savingGroup->num_participants }} rounds completed</p>
            </div>

            <!-- Winners History -->
            @if($winners->count() > 0)
                <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-800/50">
                        <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                            🏆 Winners
                        </h3>
                    </div>
                    <div class="divide-y divide-zinc-800/50">
                        @foreach($winners as $winner)
                            <div class="px-6 py-4 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center text-xs font-bold text-amber-400 border border-zinc-700">
                                        {{ $winner->won_round }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-white">{{ $winner->name }}</p>
                                        <p class="text-xs text-zinc-500">Round {{ $winner->won_round }}</p>
                                    </div>
                                </div>
                                <span class="text-sm font-semibold text-emerald-400">+${{ number_format($savingGroup->monthly_pool, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- All Participants -->
            <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-800/50">
                    <h3 class="text-sm font-semibold text-white">All Participants</h3>
                </div>
                @if($savingGroup->participants->count() > 0)
                    <div class="divide-y divide-zinc-800/50">
                        @foreach($savingGroup->participants as $p)
                            <div class="px-6 py-3 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full {{ $p->has_won ? 'bg-zinc-800 border-zinc-700' : 'bg-zinc-950 border-zinc-800' }} border flex items-center justify-center">
                                        @if($p->has_won)
                                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        @else
                                            <span class="text-xs text-zinc-500">{{ strtoupper(substr($p->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <span class="text-sm {{ $p->has_won ? 'text-zinc-500' : 'text-white' }}">{{ $p->name }}</span>
                                </div>
                                @if($p->has_won)
                                    <span class="text-xs text-emerald-500 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20">Won R{{ $p->won_round }}</span>
                                @else
                                    <span class="text-xs text-zinc-600">Waiting</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-8 text-center">
                        <p class="text-zinc-500 text-sm">No participants added yet</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Side Column — Actions -->
        <div class="space-y-6">
            <!-- Add Participant -->
            @if($needsMore > 0 && $savingGroup->status === 'active')
                <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-white mb-1">Add Participant</h3>
                    <p class="text-xs text-zinc-500 mb-4">{{ $needsMore }} more needed</p>
                    <form method="POST" action="{{ route('saving-groups.add-participant', $savingGroup) }}">
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="name" required
                                class="w-full px-4 py-2.5 bg-zinc-950 border border-zinc-800 rounded-xl text-white text-sm placeholder-zinc-600 focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all duration-200"
                                placeholder="Participant name">
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="w-full px-4 py-2.5 bg-white hover:bg-zinc-200 text-zinc-900 text-sm font-medium rounded-xl transition-all duration-200">
                            Add
                        </button>
                    </form>
                </div>
            @endif

            <!-- Draw Winner -->
            @if($canDraw && $nonWinners->count() > 0)
                <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-zinc-800 border border-zinc-700 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                    </div>
                    <h3 class="text-white font-semibold mb-1">Draw Round {{ $savingGroup->current_round + 1 }}</h3>
                    <p class="text-sm text-zinc-400 mb-4">{{ $nonWinners->count() }} eligible participants</p>
                    <form method="POST" action="{{ route('saving-groups.draw', $savingGroup) }}">
                        @csrf
                        <button type="submit" class="w-full px-6 py-3 bg-white hover:bg-zinc-200 text-zinc-900 font-semibold rounded-xl transition-all duration-200">
                            🎲 Draw Winner
                        </button>
                    </form>
                </div>
            @endif

            @if($savingGroup->status === 'completed')
                <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6 text-center">
                    <svg class="w-12 h-12 text-emerald-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-emerald-400 font-semibold">Group Completed!</h3>
                    <p class="text-sm text-emerald-500/70 mt-1">All participants have received their payout.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
