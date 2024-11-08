<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-4">Create New Event</h2>

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
    </script>
</x-app-layout>
