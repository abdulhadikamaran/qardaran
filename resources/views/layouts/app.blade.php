<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Personal Finance — {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-zinc-950 text-white min-h-screen">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <aside class="hidden lg:flex lg:flex-col w-72 bg-zinc-900 border-r border-zinc-800/50 fixed inset-y-0 left-0 z-30">
                <!-- Logo -->
                <div class="flex items-center gap-3 px-6 py-6 border-b border-zinc-800/50">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center">
                        <svg class="w-6 h-6 text-zinc-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white">Personal Finance</h1>
                        <p class="text-xs text-zinc-500">Financial Manager</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-zinc-800 text-white border border-zinc-700/50' : 'text-zinc-400 hover:text-white hover:bg-zinc-800/50 border border-transparent' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('loans.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('loans.*') ? 'bg-zinc-800 text-white border border-zinc-700/50' : 'text-zinc-400 hover:text-white hover:bg-zinc-800/50 border border-transparent' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Loans
                    </a>
                    <a href="{{ route('debts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('debts.*') ? 'bg-zinc-800 text-white border border-zinc-700/50' : 'text-zinc-400 hover:text-white hover:bg-zinc-800/50 border border-transparent' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                        Debts
                    </a>
                    <a href="{{ route('saving-groups.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('saving-groups.*') ? 'bg-zinc-800 text-white border border-zinc-700/50' : 'text-zinc-400 hover:text-white hover:bg-zinc-800/50 border border-transparent' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Saving Groups
                    </a>
                </nav>

                <!-- User Section -->
                <div class="px-4 py-4 border-t border-zinc-800/50">
                    <div class="flex items-center gap-3 px-4 py-3">
                        <div class="w-9 h-9 rounded-full bg-zinc-800 flex items-center justify-center text-sm font-bold text-white border border-zinc-700/50">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-zinc-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <div class="mt-2 space-y-1">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-400 hover:text-white hover:bg-white/5 rounded-lg transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-400 hover:text-red-400 hover:bg-red-500/5 rounded-lg transition-all duration-200 w-full text-left">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Mobile Header -->
            <div x-data="{ mobileOpen: false }" class="lg:hidden fixed top-0 inset-x-0 z-40">
                <div class="flex items-center justify-between px-4 py-3 bg-zinc-900 border-b border-zinc-800/50">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center">
                            <svg class="w-5 h-5 text-zinc-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-lg font-bold text-white">Personal Finance</span>
                    </div>
                    <button @click="mobileOpen = !mobileOpen" class="p-2 text-zinc-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>

                <!-- Mobile Menu -->
                <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" @click.away="mobileOpen = false" class="bg-zinc-900 border-b border-zinc-800/50 px-4 py-4 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-zinc-800 text-white' : 'text-zinc-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('loans.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('loans.*') ? 'bg-zinc-800 text-white' : 'text-zinc-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Loans
                    </a>
                    <a href="{{ route('debts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('debts.*') ? 'bg-zinc-800 text-white' : 'text-zinc-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                        Debts
                    </a>
                    <a href="{{ route('saving-groups.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('saving-groups.*') ? 'bg-zinc-800 text-white' : 'text-zinc-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Saving Groups
                    </a>
                    <div class="border-t border-zinc-800/50 pt-3 mt-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-red-400 w-full text-left">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main class="flex-1 lg:ml-72 pt-16 lg:pt-0">
                <!-- Page Header -->
                @isset($header)
                    <header class="px-6 lg:px-10 py-6 border-b border-white/5">
                        <div class="max-w-6xl mx-auto">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Flash Messages -->
                <div class="px-6 lg:px-10">
                    <div class="max-w-6xl mx-auto">
                        @if(session('success'))
                            <div class="mt-4 px-4 py-3 rounded-xl bg-zinc-900 border border-emerald-500/50 text-emerald-400 text-sm flex items-center gap-2">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="mt-4 px-4 py-3 rounded-xl bg-zinc-900 border border-red-500/50 text-red-400 text-sm flex items-center gap-2">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ session('error') }}
                            </div>
                        @endif
                        @if(session('info'))
                            <div class="mt-4 px-4 py-3 rounded-xl bg-zinc-900 border border-blue-500/50 text-blue-400 text-sm flex items-center gap-2">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ session('info') }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Page Content -->
                <div class="px-6 lg:px-10 py-8">
                    <div class="max-w-6xl mx-auto">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
