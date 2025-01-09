<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Available Events</h2>
                        
                        <div class="space-x-3">
                            @if (auth()->user()->is_admin)
                                <a href="{{ route('events.create') }}" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Create New Event
                                </a>
                                
                                <a href="{{ route('announcements.create') }}" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Make Announcement
                                </a>
                            @endif
                        </div>
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
                        <a href="{{ route('events.index', ['filter' => 'available']) }}" 
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
                            @forelse($events as $event)
                                <div class="hover:scale-[105%] ease-out border rounded-lg p-4 shadow hover:shadow-md transition duration-300 flex flex-col">
                                    <div class="mb-4">
                                        <img src="{{ asset('storage/' . $event->image)}}" alt="Event Image" class="w-full h-48 object-cover rounded-xl border bg-slate-100">
                                    </div>
                                    <div class="flex justify-between items-start mb-2 space-x-2">
                                        <h3 class="text-xl font-semibold">{{ $event->name }}</h3>

                                        @if($event->end_date->isPast())
                                            <span class="bg-gray-100 text-nowrap text-gray-800 text-xs px-2 py-1 rounded">Past Event</span>
                                        @else
                                            <span class="bg-green-100 text-nowrap text-green-800 text-xs px-2 py-1 rounded">Upcoming</span>
                                        @endif
                                        <span class="bg-blue-100 text-nowrap text-blue-800 text-xs px-2 py-1 rounded">
                                            {{ $event->registrations_count }} Registered
                                        </span>
                                    </div>

                                    <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit($event->description, 120) }}</p>

                                    <div class="mt-auto space-y-2">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $event->event_date->format('F d, Y') }} - {{ $event->end_date->format('F d, Y') }}
                                        </div>

                                        @if(!$event->end_date->isPast())
                                            @if(!$event->hasUserRegistered())
                                                @if(!Auth::user()->is_admin)
                                                <form action="{{ route('events.register', $event) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-200">
                                                        Register
                                                    </button>
                                                </form>
                                                @endif
                                            @endif
                                        @endif

                                        @if($event->hasUserRegistered())
                                            <div class="text-sm">
                                                <span class="text-gray-600">Registration Status:</span>
                                                <span class="ml-1 font-medium {{ $event->getUserRegistrationStatus() === 'attended' ? 'text-green-600' : 'text-blue-600' }}">
                                                    {{ ucfirst($event->getUserRegistrationStatus()) }}
                                                </span>
                                            </div>
                                        @endif

                                        @if($event->userCanRequestCertificate())
                                            <form action="{{ route('certificates.request', $event) }}" method="POST">
                                                @csrf
                                                <button type="submit" 
                                                        class="w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors duration-200">
                                                    Request Certificate
                                                </button>
                                            </form>
                                        @elseif($event->hasUserRequestedCertificate())
                                            <div class="text-center bg-gray-100 px-4 py-2 rounded">
                                                Certificate Status: 
                                                <span class="font-medium">
                                                    {{ ucfirst($event->getUserCertificateStatus()) }}
                                                </span>
                                            </div>
                                        @endif

                                        @if (auth()->user()->is_admin)
                                            <a href="{{ route('events.registrations.index', $event) }}" 
                                            class="flex-1 block text-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-200">
                                                Manage Registrations
                                            </a>
                                        @endif

                                        <div class="flex space-x-2">
                                            <a href="{{ route('events.show', $event) }}" 
                                            class="flex-1 block text-center text-blue-500 hover:text-blue-700 transition-colors duration-200">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="text-gray-500 text-lg font-medium">No events found</p>
                                            <p class="text-gray-400 text-sm mt-1">Events will appear here once created</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </div>


                        <div class="mt-6">
                            {{ $events->links() }}
                        </div>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>