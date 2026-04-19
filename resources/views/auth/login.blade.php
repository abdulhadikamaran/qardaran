<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-xl font-bold text-white mb-1">Welcome back</h2>
    <p class="text-sm text-zinc-500 mb-6">Sign in to your account</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-zinc-400 mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="w-full px-4 py-3 bg-zinc-950 border border-zinc-800 rounded-xl text-white placeholder-zinc-600 focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all duration-200"
                placeholder="name@example.com">
            @error('email')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block text-sm font-medium text-zinc-400 mb-2">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full px-4 py-3 bg-zinc-950 border border-zinc-800 rounded-xl text-white placeholder-zinc-600 focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all duration-200"
                placeholder="••••••••">
            @error('password')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-zinc-950 border-zinc-800 text-white focus:ring-white focus:ring-offset-zinc-900" name="remember">
                <span class="ms-2 text-sm text-zinc-500">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-white hover:text-zinc-300 transition-colors" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="w-full mt-6 px-6 py-3 bg-white hover:bg-zinc-200 text-zinc-900 font-semibold rounded-xl transition-all duration-200">
            Sign in
        </button>

        <p class="mt-4 text-center text-sm text-zinc-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-white hover:text-zinc-300 font-medium transition-colors">Sign up</a>
        </p>
    </form>
</x-guest-layout>
