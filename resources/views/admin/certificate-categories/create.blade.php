<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="max-w-lg mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Create Certificate Category</h1>
                <a href="{{ route('admin.certificate-categories.index') }}" 
                class="text-blue-500 hover:text-blue-600">
                    Back to List
                </a>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('admin.certificate-categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
                        <input type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('name') border-red-500 @enderror"
                            required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                        <textarea name="description" 
                                id="description" 
                                rows="3"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="certificate_template" class="block text-sm font-medium text-gray-700">
                            Certificate Template
                        </label>
                        <div class="mt-2 space-y-4">
                            <div class="flex items-center justify-center w-full">
                                <label for="certificate_template" 
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

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            Create Category
                        </button>
                    </div>
                </form>
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
    </script>
</x-app-layout>