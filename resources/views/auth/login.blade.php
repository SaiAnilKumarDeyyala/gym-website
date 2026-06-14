<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-white tracking-wide uppercase">Staff Portal</h2>
        <p class="text-gray-400 text-sm mt-2">Enter your credentials to access the dashboard</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block font-medium text-sm text-gray-300">Email Address</label>
            <input id="email" class="block mt-1 w-full bg-gray-800 border-gray-700 text-white focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <div>
            <div class="flex justify-between items-center">
                <label for="password" class="block font-medium text-sm text-gray-300">Password</label>
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-400 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 focus:ring-offset-gray-900 transition" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>
            
            <input id="password" class="block mt-1 w-full bg-gray-800 border-gray-700 text-white focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded bg-gray-800 border-gray-700 text-red-600 shadow-sm focus:ring-red-500 focus:ring-offset-gray-900 cursor-pointer" name="remember">
                <span class="ms-2 text-sm text-gray-400">Remember me</span>
            </label>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-red-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition ease-in-out duration-150 shadow-lg shadow-red-600/30">
                Log In
            </button>
        </div>
        
        @if (Route::has('register'))
        <div class="mt-6 text-center text-sm text-gray-400 border-t border-gray-800 pt-6">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-white hover:text-red-500 font-semibold transition">Sign up</a>
        </div>
        @endif
    </form>
</x-guest-layout>