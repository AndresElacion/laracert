<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Edit Event</h2>
                        <a href="{{ route('events.show', $event) }}" 
                           class="text-gray-600 hover:text-gray-800">
                            &larr; Back to Event
                        </a>
                    </div>

                    <form action="{{ route('events.update', $event) }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Event Name
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $event->name) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="event_date" class="block text-sm font-medium text-gray-700">
                                Event Date and Time
                            </label>
                            <input type="datetime-local" 
                                   name="event_date" 
                                   id="event_date" 
                                   value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('event_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Description
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="4" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Certificate Template
                            </label>
                            <div class="mt-2 space-y-4">
                                @if($event->certificate_template)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-2">Current template:</p>
                                        <img src="{{ Storage::url($event->certificate_template) }}" 
                                             alt="Current certificate template" 
                                             class="max-w-md rounded-lg shadow-sm">
                                    </div>
                                @endif

                                <div class="flex items-center justify-center w-full">
                                    <label for="certificate_template" 
                                           class="w-full flex flex-col items-center px-4 py-6 bg-white rounded-lg border-2 border-gray-300 border-dashed cursor-pointer hover:bg-gray-50">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-500">
                                                <span class="font-semibold">Click to upload</span> or drag and drop
                                            </p>
                                            <p class="text-xs text-gray-500">JPG, JPEG, PNG (Max. 5MB)</p>
                                        </div>
                                        <input type="file" 
                                               name="certificate_template" 
                                               id="certificate_template"
                                               accept=".jpg,.jpeg,.png"
                                               class="hidden"
                                               onchange="previewImage(this)">
                                    </label>
                                </div>
                                
                                <!-- Image Preview -->
                                <div id="imagePreview" class="hidden mt-4">
                                    <p class="text-sm text-gray-500 mb-2">Preview:</p>
                                    <img id="preview" src="#" alt="Template preview" class="max-w-md rounded-lg shadow-sm">
                                </div>

                                @error('certificate_template')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-between pt-4">
                            <button type="button" 
                                    onclick="window.location.href='{{ route('events.show', $event) }}'"
                                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded transition-colors duration-200">
                                Cancel
                            </button>
                            
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded transition-colors duration-200">
                                Update Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this script for image preview -->
    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            const previewDiv = document.getElementById('imagePreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewDiv.classList.remove('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>