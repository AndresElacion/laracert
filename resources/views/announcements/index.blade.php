<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Announcements</h2>
                        
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('announcements.create') }}" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Make Announcement
                            </a>
                        @endif
                    </div>
                    
                    <div class="mb-5">
                        <div class="flex justify-end items-center">
                            <!-- Search form -->
                            <form action="{{ route('events.search') }}" method="GET" class="flex items-center w-full sm:w-auto">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="w-full sm:w-64 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Search events...">
                                <button type="submit"
                                        class="ml-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                                    Search
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        <a href="{{ route('events.index') }}" 
                            class="transform transition-transform hover:scale-105">
                                <div class="relative overflow-hidden rounded-xl border p-6 
                                    {{ request()->query('filter') === 'available' ? 'bg-green-200' : 'bg-green-100' }} 
                                    border-green-200">
                                    <div class="flex items-center gap-4">
                                        <p class="text-sm font-medium text-gray-600">Available Events</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('events.index', ['filter' => 'past']) }}" 
                            class="transform transition-transform hover:scale-105">
                                <div class="relative overflow-hidden rounded-xl border p-6 
                                    {{ request()->query('filter') === 'past' ? 'bg-red-200' : 'bg-red-100' }} 
                                    border-green-200">
                                    <div class="flex items-center gap-4">
                                        <p class="text-sm font-medium text-gray-600">Past Events</p>
                                    </div>
                                </div>
                            </a>
                            
                            <a href="{{ route('announcements.index') }}" 
                                class="transform transition-transform hover:scale-105">
                                <div class="relative overflow-hidden rounded-xl border p-6 
                                    {{ request()->query('filter') === 'announcements' ? 'bg-slate-200' : 'bg-slate-100' }} 
                                    border-green-200">
                                    <div class="flex items-center gap-4">
                                        <p class="text-sm font-medium text-gray-600">Announcements</p>
                                    </div>
                                </div>
                            </a>

                    </div>
                    
                    {{-- @if($events->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">No events available at the moment.</p>
                        </div>
                    @else --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($announcements as $announcement)
                            <div class="bg-white shadow rounded-lg p-6">
                                <a href="{{ route('announcements.show', $announcement) }}" 
                                    class="transform transition-transform hover:scale-105">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold">{{ $announcement->title }}</h3>
                                            <p class="text-gray-600 mt-2">{{ $announcement->description }}</p>
                                            <div class="mt-2 text-sm text-gray-500">
                                                Related to: {{ $announcement->event->name }}
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('announcements.edit', $announcement) }}" 
                                            class="text-blue-500 hover:text-blue-700">Edit</a>
                                            <form action="{{ route('announcements.destroy', $announcement) }}" 
                                                method="POST" 
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-500 hover:text-red-700">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">No announcements found.</p>
                        @endforelse
                    </div>


                        <div class="mt-6">
                            {{ $announcements->links() }}
                        </div>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>