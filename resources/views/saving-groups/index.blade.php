<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white">Saving Groups</h2>
                <p class="text-sm text-slate-400 mt-1">Manage your community saving circles</p>
            </div>
            <a href="{{ route('saving-groups.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white hover:bg-zinc-200 text-zinc-900 text-sm font-medium rounded-xl transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Create Group
            </a>
        </div>
    </x-slot>

    <!-- Active Groups -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-violet-400 animate-pulse"></span>
            Active Groups ({{ $activeGroups->count() }})
        </h3>
        @if($activeGroups->count() > 0)
            <div class="grid gap-4 md:grid-cols-2">
                @foreach($activeGroups as $group)
                    <a href="{{ route('saving-groups.show', $group) }}" class="block bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6 hover:border-zinc-700 transition-all duration-300 group">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-zinc-800 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <span class="text-xs text-violet-400 font-medium bg-zinc-800 border border-zinc-700 px-2.5 py-1 rounded-full">Round {{ $group->current_round }}/{{ $group->num_participants }}</span>
                        </div>
                        <h4 class="text-white font-semibold text-lg">{{ $group->name }}</h4>
                        <div class="mt-3 space-y-1.5">
                            <p class="text-sm text-zinc-400">{{ $group->num_participants }} participants · ${{ number_format($group->contribution_amount, 2) }}/month</p>
                            <p class="text-sm text-violet-400 font-medium">Monthly pool: ${{ number_format($group->monthly_pool, 2) }}</p>
                        </div>
                        <div class="mt-4 w-full h-1.5 bg-zinc-800 rounded-full">
                            <div class="h-full bg-white rounded-full transition-all duration-500" style="width: {{ $group->num_participants > 0 ? ($group->current_round / $group->num_participants) * 100 : 0 }}%"></div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-12 text-center">
                <svg class="w-12 h-12 text-zinc-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <p class="text-zinc-400 font-medium">No active saving groups</p>
                <p class="text-zinc-600 text-sm mt-1">Create one to start saving together</p>
            </div>
        @endif
    </div>

    <!-- Completed Groups -->
    @if($completedGroups->count() > 0)
        <div>
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Completed ({{ $completedGroups->count() }})
            </h3>
            <div class="grid gap-3">
                @foreach($completedGroups as $group)
                    <a href="{{ route('saving-groups.show', $group) }}" class="block bg-zinc-900 border border-zinc-800/50 rounded-xl p-4 hover:bg-zinc-800 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-zinc-800 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <p class="text-zinc-300 text-sm font-medium">{{ $group->name }}</p>
                                    <p class="text-xs text-zinc-500">{{ $group->num_participants }} participants · ${{ number_format($group->monthly_pool, 2) }}/round</p>
                                </div>
                            </div>
                            <span class="text-xs text-emerald-500 font-medium bg-zinc-800 border border-zinc-700 px-2.5 py-1 rounded-full">DONE</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</x-app-layout>
