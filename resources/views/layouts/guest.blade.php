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
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Logo -->
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center">
                    <svg class="w-7 h-7 text-zinc-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Personal Finance</h1>
                    <p class="text-xs text-zinc-500">Secure Financial Management</p>
                </div>
            </div>

            <!-- Card -->
            <div class="w-full sm:max-w-md px-8 py-8 bg-zinc-900 border border-zinc-800/50 rounded-2xl">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <p class="mt-6 text-xs text-zinc-600">&copy; {{ date('Y') }} Personal Finance. All rights reserved.</p>
        </div>
    </body>
</html>
