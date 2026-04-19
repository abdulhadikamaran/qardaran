<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white">Debts</h2>
                <p class="text-sm text-slate-400 mt-1">Track and pay off your debts</p>
            </div>
            <a href="{{ route('debts.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white hover:bg-zinc-200 text-zinc-900 text-sm font-medium rounded-xl transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Add Debt
            </a>
        </div>
    </x-slot>

    <!-- Tabs -->
    <div x-data="{ tab: 'current' }" class="space-y-6">
        <div class="flex gap-1 bg-zinc-900 border border-zinc-800/50 p-1 rounded-xl w-fit">
            <button @click="tab = 'current'" :class="tab === 'current' ? 'bg-zinc-800 text-white border-zinc-700/50' : 'text-zinc-500 border-transparent hover:text-white'" class="px-5 py-2 text-sm font-medium rounded-lg border transition-all duration-200">
                Current ({{ $currentDebts->count() }})
            </button>
            <button @click="tab = 'paid'" :class="tab === 'paid' ? 'bg-zinc-800 text-white border-zinc-700/50' : 'text-zinc-500 border-transparent hover:text-white'" class="px-5 py-2 text-sm font-medium rounded-lg border transition-all duration-200">
                Old / Paid ({{ $paidDebts->count() }})
            </button>
        </div>

        <!-- Current Debts -->
        <div x-show="tab === 'current'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            @if($currentDebts->count() > 0)
                <div class="grid gap-4">
                    @foreach($currentDebts as $debt)
                        <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-6 hover:border-zinc-700 transition-all duration-300">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-rose-500/10 flex items-center justify-center shrink-0">
                                        <svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-white font-semibold">{{ $debt->description }}</p>
                                        <p class="text-xs text-zinc-500">Total: ${{ number_format($debt->amount, 2) }} · Paid: ${{ number_format($debt->amount_paid, 2) }}</p>
                                        <p class="text-xs text-zinc-500 mt-0.5">{{ $debt->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 sm:gap-6">
                                    <div class="text-right">
                                        <p class="text-xs text-zinc-500">Remaining</p>
                                        <p class="text-lg font-bold text-rose-400">${{ number_format($debt->remaining, 2) }}</p>
                                        <div class="w-32 h-1.5 bg-zinc-800 rounded-full mt-1">
                                            <div class="h-full bg-white rounded-full transition-all duration-500" style="width: {{ $debt->amount > 0 ? ($debt->amount_paid / $debt->amount) * 100 : 0 }}%"></div>
                                        </div>
                                    </div>
                                    <a href="{{ route('debts.pay', $debt) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-white text-sm font-medium rounded-xl border border-zinc-700/50 transition-all duration-200">
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
                    <p class="text-zinc-400 font-medium">No current debts</p>
                    <p class="text-zinc-600 text-sm mt-1">You're all clear!</p>
                </div>
            @endif
        </div>

        <!-- Paid/Old Debts -->
        <div x-show="tab === 'paid'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            @if($paidDebts->count() > 0)
                <div class="grid gap-3">
                    @foreach($paidDebts as $debt)
                        <div class="bg-zinc-900 border border-zinc-800/50 rounded-xl p-4 hover:bg-zinc-800 transition-colors">
                            <div class="flex items-center justify-between">
                                <a href="{{ route('debts.show', $debt) }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-zinc-300 text-sm font-medium hover:text-white transition-colors">{{ $debt->description }}</p>
                                        <p class="text-xs text-zinc-500">${{ number_format($debt->amount, 2) }} · Paid {{ $debt->updated_at->format('M d, Y') }}</p>
                                    </div>
                                </a>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-emerald-500 font-medium bg-emerald-500/10 px-2.5 py-1 rounded-full border border-emerald-500/20">PAID</span>
                                    <form method="POST" action="{{ route('debts.destroy', $debt) }}" onsubmit="return confirm('Remove this old debt record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-zinc-500 hover:text-red-400 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-zinc-900 border border-zinc-800/50 rounded-2xl p-12 text-center">
                    <p class="text-zinc-500 text-sm">No paid debts yet</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
