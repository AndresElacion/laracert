<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-4">Create New Event</h2>

                    @if(isset($error))
                        <p>{{$error}}</p>
                    @endif
                    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Event Name
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Description
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      required 
                                      rows="4" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">
                                Event Image
                            </label>
                            <div class="mt-2 space-y-4">
                                <div class="flex items-center justify-center w-full">
                                    <label for="image" 
                                            class="w-full flex flex-col items-center px-4 py-6 bg-white rounded-lg border-2 border-gray-300 border-dashed cursor-pointer hover:bg-gray-50">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500">
                                            <span class="font-semibold">Click to upload</span> or drag and drop
                                        </p>
                                        <p class="text-xs text-gray-500">JPG, JPEG, PNG (Max. 5MB)</p>
                                        <input type="file" 
                                                name="image" 
                                                id="image"
                                                accept=".jpg,.jpeg,.png"
                                                class="hidden"
                                                onchange="eventImage(this)">
                                    </label>
                                </div>

                                <!-- Image Preview -->
                                <div id="imageEvent" class="hidden mt-4">
                                    <p class="text-sm text-gray-500 mb-2">Preview:</p>
                                    <img id="event" src="#" alt="Template preview" class="max-w-md rounded-lg shadow-sm">
                                </div>

                                @error('certificate_template')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="event_date" class="block text-sm font-medium text-gray-700">
                                Event Date
                            </label>
                            <input type="date" 
                                   id="event_date" 
                                   name="event_date" 
                                   required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('event_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">
                                End Date
                            </label>
                            <input type="date" 
                                   id="end_date" 
                                   name="end_date" 
                                   required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="coordinator_id" class="block text-sm font-medium text-gray-700">
                                Event Coordinators (Select up to 5)
                            </label>
                            <div class="mt-1">
                                <select id="coordinator_id"
                                        name="coordinator_id[]" 
                                        multiple
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        style="display: none;">
                                    @foreach($coordinators as $coordinator)
                                        <option value="{{ $coordinator->id }}" 
                                            {{ (is_array(old('coordinator_id')) && in_array($coordinator->id, old('coordinator_id'))) ? 'selected' : '' }}>
                                            {{ $coordinator->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div id="custom-select" class="border rounded-md border-gray-300 p-2 space-y-2">
                                    <div id="selected-coordinators" class="space-y-2"></div>
                                    <div class="relative">
                                        <select id="coordinator-dropdown" 
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="">Select a coordinator</option>
                                            @foreach($coordinators as $coordinator)
                                                <option value="{{ $coordinator->id }}" data-name="{{ $coordinator->name }}">
                                                    {{ $coordinator->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @error('coordinator_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('coordinator_id.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">
                                Select up to 5 coordinators from the dropdown.
                            </p>
                        </div>

                        <div>
                            <label for="certificate_template_category_id" class="block text-sm font-medium text-gray-700">
                                Certificate Template Category
                            </label>
                            <select id="certificate_template_category_id" 
                                    name="certificate_template_category_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    onchange="showCategoryTemplatePreview(this)">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" data-image="{{ asset('storage/' . $category->certificate_template) }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('certificate_template_category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Template Category Image Preview -->
                        <div id="categoryTemplatePreview" class="hidden mt-4">
                            <p class="text-sm text-gray-500 mb-2">Preview of the selected category template:</p>
                            <img id="categoryTemplate" src="#" alt="Category Template Preview" class="max-w-md rounded-lg shadow-sm">
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded transition-colors duration-200">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

        function eventImage(input) {
            const event = document.getElementById('event');
            const eventDiv = document.getElementById('imageEvent');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    event.src = e.target.result;
                    eventDiv.classList.remove('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        function showCategoryTemplatePreview(select) {
            const categoryImage = select.selectedOptions[0].getAttribute('data-image');
            const previewDiv = document.getElementById('categoryTemplatePreview');
            const categoryTemplate = document.getElementById('categoryTemplate');
            
            if (categoryImage) {
                categoryTemplate.src = categoryImage;
                previewDiv.classList.remove('hidden');
            } else {
                previewDiv.classList.add('hidden');
            }
        }

    document.addEventListener('DOMContentLoaded', function() {
        const hiddenSelect = document.getElementById('coordinator_id');
        const customDropdown = document.getElementById('coordinator-dropdown');
        const selectedCoordinatorsDiv = document.getElementById('selected-coordinators');
        let selectedCoordinators = [];

        // Initialize with any pre-selected values (e.g., from old input)
        Array.from(hiddenSelect.selectedOptions).forEach(option => {
            addCoordinator(option.value, option.text);
        });

        customDropdown.addEventListener('change', function() {
            const selectedId = this.value;
            if (!selectedId) return;

            const selectedName = this.options[this.selectedIndex].dataset.name;
            
            if (selectedCoordinators.length >= 5) {
                alert('You can only select up to 5 coordinators.');
                this.value = '';
                return;
            }

            if (!selectedCoordinators.find(c => c.id === selectedId)) {
                addCoordinator(selectedId, selectedName);
            }

            // Reset dropdown
            this.value = '';
        });

        function addCoordinator(id, name) {
            selectedCoordinators.push({ id, name });
            updateUI();
            updateHiddenSelect();
        }

        function removeCoordinator(id) {
            selectedCoordinators = selectedCoordinators.filter(c => c.id !== id);
            updateUI();
            updateHiddenSelect();
        }

        function updateUI() {
            selectedCoordinatorsDiv.innerHTML = '';
            selectedCoordinators.forEach(coordinator => {
                const div = document.createElement('div');
                div.className = 'flex items-center justify-between bg-blue-50 p-2 rounded';
                div.innerHTML = `
                    <span class="text-blue-700">${coordinator.name}</span>
                    <button type="button" 
                            class="text-blue-500 hover:text-blue-700"
                            onclick="this.closest('div').dispatchEvent(new CustomEvent('remove-coordinator', { detail: '${coordinator.id}' }))">
                        ×
                    </button>
                `;
                div.addEventListener('remove-coordinator', (e) => removeCoordinator(e.detail));
                selectedCoordinatorsDiv.appendChild(div);
            });
        }

        function updateHiddenSelect() {
            Array.from(hiddenSelect.options).forEach(option => {
                option.selected = selectedCoordinators.some(c => c.id === option.value);
            });
        }
    });
    </script>
</x-app-layout>
