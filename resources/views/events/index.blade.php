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
                        
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('events.create') }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create New Event
                            </a>
                        @endif
                    </div>
                    
                    @if($events->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">No events available at the moment.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($events as $event)
                            <div class="hover:scale-[105%] ease-out border rounded-lg p-4 shadow hover:shadow-md transition duration-300 flex flex-col">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-xl font-semibold">{{ $event->name }}</h3>

                                    @if($event->event_date->isPast())
                                        <span class="bg-gray-100 text-nowrap text-gray-800 text-xs px-2 py-1 rounded">Past Event</span>
                                    @else
                                        <span class="bg-green-100 text-nowrap text-green-800 text-xs px-2 py-1 rounded">Upcoming</span>
                                    @endif
                                </div>

                                <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit($event->description, 120) }}</p>

                                @if(isset($event->coordinators))
                                    <div class="grid grid-cols-2">
                                        @foreach($event->coordinators as $coordinator)
                                            <div class="flex items-center space-x-2 text-gray-600 line-clamp-3">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v2h20v-2c0-3.3-6.7-5-10-5z"/>
                                                </svg>
                                                <span>{{ $coordinator->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="mt-auto space-y-2">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $event->event_date->format('F d, Y - h:i A') }}
                                    </div>

                                    @if(!$event->event_date->isPast())
                                        @if(!$event->hasUserRegistered())
                                            <form action="{{ route('events.register', $event) }}" method="POST">
                                                @csrf
                                                <button type="submit" 
                                                        class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-200">
                                                    Register
                                                </button>
                                            </form>
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
                            @endforeach
                        </div>


                        <div class="mt-6">
                            {{ $events->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>