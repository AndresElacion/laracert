<x-guest-layout>
    <main class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('img/background_overlay.png') }}'); background-size: 50%; background-repeat: no-repeat;">
        
        <div class="bg-white bg-opacity-80 max-w-md w-full p-8 rounded-lg shadow-lg">

            <h1 class="text-3xl text-slate-800 font-bold mb-6 text-center">Welcome back! ✨</h1>

            <!-- Sign Up / Login -->
            <div class="pt-5 my-6 border-t border-slate-200 text-center">
                <div class="text-sm space-x-5">
                    <a href="{{ route('login')}}" 
                        class="border border-transparent rounded-md font-semibold text-xs px-4 py-2 mt-2 bg-pink-500 hover:bg-pink-600 text-white transition-colors duration-200">
                        Login
                    </a>
                    <a href="{{ route('register')}}" 
                        class="border border-transparent rounded-md font-semibold text-xs px-4 py-2 mt-2 bg-gray-400 hover:bg-pink-600 text-white transition-colors duration-200">
                        Sign up
                    </a>
                </div>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </main>
</x-guest-layout>
