<x-guest-layout>
    <main class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('img/background_overlay.png') }}'); background-size: 50%; background-repeat: no-repeat;">
        
        <div class="bg-white bg-opacity-80 max-w-3xl w-full p-8 rounded-lg shadow-lg">

            <h1 class="text-3xl text-slate-800 font-bold mb-6 text-center">Register</h1>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-3 gap-4">

                    <!-- First Name -->
                    <div>
                        <x-input-label for="first_name" :value="__('First Name')" />
                        <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />
                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                    </div>

                    <!-- Middle Name -->
                    <div>
                        <x-input-label for="middle_name" :value="__('Middle Name')" />
                        <x-text-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name" :value="old('middle_name')" />
                        <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                    </div>

                    <!-- Last Name -->
                    <div>
                        <x-input-label for="last_name" :value="__('Last Name')" />
                        <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required />
                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- ID Number -->
                    <div>
                        <x-input-label for="id_number" :value="__('ID Number')" />
                        <x-text-input id="id_number" class="block mt-1 w-full" type="text" name="id_number" :value="old('id_number')" required />
                        <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
                    </div>

                    <!-- Section -->
                    <div>
                        <x-input-label for="section" :value="__('Section')" />
                        <x-text-input id="section" class="block mt-1 w-full" type="text" name="section" :value="old('section')" required />
                        <x-input-error :messages="$errors->get('section')" class="mt-2" />
                    </div>

                    <!-- Year -->
                    <div>
                        <x-input-label for="year" :value="__('Year')" />
                        <x-text-input id="year" class="block mt-1 w-full" type="text" name="year" :value="old('year')" required />
                        <x-input-error :messages="$errors->get('year')" class="mt-2" />
                    </div>

                    <!-- Student ID Image -->
                    <div class="col-span-3">
                        <x-input-label for="student_id_image" :value="__('Student ID Image')" />
                        <x-text-input id="student_id_image" class="block mt-1 w-full" type="file" name="student_id_image" required />
                        <x-input-error :messages="$errors->get('student_id_image')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ml-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </main>
</x-guest-layout>
