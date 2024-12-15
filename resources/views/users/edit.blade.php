<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-2 gap-4">
                            <!-- First Name -->
                            <div>
                                <x-input-label for="first_name" :value="__('First Name')" />
                                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name', $user->first_name)" required />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>

                            <!-- Middle Name -->
                            <div>
                                <x-input-label for="middle_name" :value="__('Middle Name')" />
                                <x-text-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name" :value="old('middle_name', $user->middle_name)" />
                                <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                            </div>

                            <!-- Last Name -->
                            <div>
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name', $user->last_name)" required />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>

                            <!-- ID Number -->
                            <div>
                                <x-input-label for="id_number" :value="__('ID Number')" />
                                <x-text-input id="id_number" class="block mt-1 w-full" type="text" name="id_number" :value="old('id_number', $user->id_number)" required />
                                <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
                            </div>

                            <!-- Section -->
                            <div>
                                <x-input-label for="section" :value="__('Section')" />
                                <x-text-input id="section" class="block mt-1 w-full" type="text" name="section" :value="old('section', $user->section)" required />
                                <x-input-error :messages="$errors->get('section')" class="mt-2" />
                            </div>

                            <!-- Department -->
                            <div>
                                <x-input-label for="department_id" :value="__('Department')" />
                                <select id="department_id" name="department_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                            </div>

                            <!-- Year -->
                            <div>
                                <x-input-label for="year" :value="__('Year Level')" />
                                <x-text-input id="year" class="block mt-1 w-full" type="text" name="year" :value="old('year', $user->year)" required />
                                <x-input-error :messages="$errors->get('year')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div>
                                <x-input-label for="password" :value="__('Password (leave blank to keep current)')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Student ID Image -->
                            <div>
                                <x-input-label for="student_id_image" :value="__('Student ID Image')" />
                                @if($user->student_id_image)
                                    <div class="mt-2">
                                        <img id="currentImage" src="{{ Storage::url($user->student_id_image) }}" alt="Student ID" class="w-32 h-32 object-cover cursor-pointer" onclick="showModal('{{ Storage::url($user->student_id_image) }}')">
                                    </div>
                                @endif
                                @if(!Auth::user()->is_admin)
                                    <input type="file" id="student_id_image" name="student_id_image" class="block mt-1 w-full" />
                                    <x-input-error :messages="$errors->get('student_id_image')" class="mt-2" />
                                    @endif
                            </div>

                            <!-- Modal -->
                            <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                                <div class="bg-white p-4 rounded shadow-lg max-w-md">
                                    <div class="text-red-500 float-right cursor-pointer" onclick="closeModal()">✖</div>
                                    <img id="modalImage" src="" alt="Preview" class="max-w-full h-auto mt-4">
                                </div>
                            </div>


                            <!-- Is Admin -->
                            <div>
                                <label for="is_admin" class="inline-flex items-center mt-4">
                                    <input type="checkbox" id="is_admin" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Admin Role') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update User') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');

            modalImage.src = imageSrc; // Set the image source for the modal
            modal.classList.remove('hidden'); // Display the modal
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden'); // Hide the modal
        }

    </script>
</x-app-layout>