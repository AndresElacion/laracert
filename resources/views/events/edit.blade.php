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
                                Event Start Date
                            </label>
                            <input type="datetime-local" 
                                   name="event_date" 
                                   id="event_date" 
                                   value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('event_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">
                                Event End Date
                            </label>
                            <input type="datetime-local" 
                                   name="end_date" 
                                   id="end_date" 
                                   value="{{ old('end_date', $event->end_date->format('Y-m-d')) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('end_date')
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
                                        <option {{ in_array($coordinator->id, $event->coordinators->pluck('id')->toArray()) ? 'selected' : ''}} value="{{ $coordinator->id }}" 
                                            {{ (is_array(old('coordinator_id')) && in_array($coordinator->id, old('coordinator_id'))) ? 'selected' : '' }}>
                                            {{ $coordinator->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Custom UI for coordinator selection -->
                                <div id="custom-select" class="border rounded-md border-gray-300 p-2 space-y-2">
                                    <!-- Selected coordinators will appear here -->
                                    <div id="selected-coordinators" class="space-y-2"></div>
                                    
                                    <!-- Dropdown for selecting coordinators -->
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
                            <label class="block text-sm font-medium text-gray-700">
                                Certificate Template
                            </label>
                            <div class="mt-2 space-y-4">
                                @if($event->certificateTemplateCategory->certificate_template)
                                    <div class="mb-4">
                                        <img src="{{ Storage::url($event->certificateTemplateCategory->certificate_template) }}" 
                                             alt="Current certificate template" 
                                             class="max-w-md rounded-lg shadow-sm">
                                    </div>
                                @endif
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

    <script>
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
                // Update the hidden select for form submission
                Array.from(hiddenSelect.options).forEach(option => {
                    option.selected = selectedCoordinators.some(c => c.id === option.value);
                });
            }
        });
    </script>
</x-app-layout>
