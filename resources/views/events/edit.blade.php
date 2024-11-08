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
</x-app-layout>
