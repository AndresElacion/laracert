<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">{{ __('Profile Information') }}</h2>
        <p class="mt-1 text-sm text-gray-600">{{ __("Update your account's profile information.") }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Flex container for two columns -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- First Name Field -->
            <div>
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>

            <!-- Middle Name Field -->
            <div>
                <x-input-label for="middle_name" :value="__('Middle Name')" />
                <x-text-input id="middle_name" name="middle_name" type="text" class="mt-1 block w-full" :value="old('middle_name', $user->middle_name)" />
                <x-input-error class="mt-2" :messages="$errors->get('middle_name')" />
            </div>

            <!-- Last Name Field -->
            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" required />
                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>

            <!-- ID Number Field -->
            <div>
                <x-input-label for="id_number" :value="__('ID Number')" />
                <x-text-input id="id_number" name="id_number" type="text" class="mt-1 block w-full" :value="old('id_number', $user->id_number)" required />
                <x-input-error class="mt-2" :messages="$errors->get('id_number')" />
            </div>

            <!-- Section Field -->
            <div>
                <x-input-label for="section" :value="__('Section')" />
                <x-text-input id="section" name="section" type="text" class="mt-1 block w-full" :value="old('section', $user->section)" required />
                <x-input-error class="mt-2" :messages="$errors->get('section')" />
            </div>

            <!-- Department Field -->
            <div>
                <x-input-label for="department_id" :value="__('Department')" />
                <select name="department_id" id="department_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    @foreach($departments as $department)
                        <option {{ $user->department_id == $department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('department_id')" />
            </div>

            <!-- Year Field -->
            <div>
                <x-input-label for="year" :value="__('Year')" />
                <x-text-input id="year" name="year" type="text" class="mt-1 block w-full" :value="old('year', $user->year)" required />
                <x-input-error class="mt-2" :messages="$errors->get('year')" />
            </div>

            <!-- Student ID Image Field with Preview -->
            <div class="col-span-1 md:col-span-2">
                <x-input-label for="student_id_image" :value="__('Student ID Image')" />
                <x-text-input id="student_id_image" name="student_id_image" type="file" class="mt-1 block w-full" accept="image/*" onchange="previewImage(event)" />
                <x-input-error class="mt-2" :messages="$errors->get('student_id_image')" />

                <!-- Preview Image -->
                <div class="mt-2">
                    @if ($user->student_id_image)
                        <img id="imagePreview" src="{{ asset('storage/' . $user->student_id_image) }}" alt="Student ID Image" class="h-32 w-32 object-cover">
                    @else
                        <img id="imagePreview" class="h-32 w-32 object-cover hidden">
                    @endif
                </div>
            </div>

            <!-- Email Field -->
            <div class="col-span-1 md:col-span-2">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
        </div>

        <!-- Save Button and Confirmation -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <script>
        function previewImage(event) {
            const imagePreview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</section>
