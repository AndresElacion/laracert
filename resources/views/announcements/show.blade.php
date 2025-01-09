<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <a href="{{ route('announcements.index') }}" 
                           class="text-blue-500 hover:text-blue-700">
                            &larr; Back to Announcements
                        </a>
                    </div>

                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex justify-end">
                             @if(auth()->user()->is_admin)
                                <div class="flex space-x-2">
                                    <a href="{{ route('announcements.edit', $announcement) }}" 
                                        class="bg-blue-500 hover:bg-blue-700 text-white rounded-md px-4 py-2">
                                        Edit
                                    </a>
                                    <form action="{{ route('announcements.destroy', $announcement) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-700 text-white rounded-md px-4 py-2">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col justify-between items-start">
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $announcement->event->image)}}" alt="Event Image" class="w-full h-48 object-cover rounded-xl border bg-slate-100">
                            </div>
                            <h1 class="text-2xl font-bold mb-4">{{ $announcement->title }}</h1>
                        </div>

                        <div class="mt-6">
                            <p class="text-gray-700 text-lg">{{ $announcement->description }}</p>
                        </div>

                        <div class="mt-6 border-t pt-4">
                            <div class="text-sm text-gray-600">
                                <p>Posted: {{ $announcement->created_at->format('F j, Y, g:i a') }}</p>
                                @if($announcement->event)
                                    <p class="mt-1">Related Event: {{ $announcement->event->name }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>