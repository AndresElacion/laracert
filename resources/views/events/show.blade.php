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
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-2xl font-bold mb-2">{{ $event->name }}</h2>
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $event->event_date->format('F d, Y') }} - {{ $event->end_date->format('F d, Y') }}
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            @if($event->end_date->isPast())
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">Past Event</span>
                            @else
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">Upcoming</span>
                            @endif

                            @if (auth()->user()->is_admin)
                                <a href="{{ route('events.edit', $event) }}" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit Event
                                </a>

                                <!-- Add the delete form here -->
                                <form action="{{ route('events.destroy', $event) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm">
                                        Delete Event
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="prose max-w-none mb-8">
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $event->image)}}" alt="Event Image" class="w-3/12 rounded-xl border bg-slate-100 p-1">
                        </div>
                        <p class="text-gray-600 mb-4">{!! nl2br($event->description) !!}</p>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4">Registration & Certificate Status</h3>
                        
                        <div class="space-y-4">
                            @if(!$event->end_date->isPast())
                                @if(!$event->hasUserRegistered())
                                    <form action="{{ route('events.register', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded transition-colors duration-200">
                                            Register for Event
                                        </button>
                                    </form>
                                @else
                                    <div class="bg-green-50 border border-green-200 rounded p-4">
                                        <p class="text-green-700">You are registered for this event</p>
                                        <p class="text-sm text-green-600 mt-1">Registration Date: 
                                            {{ $event->registrations->where('user_id', auth()->id())->first()->created_at->format('F d, Y') }}
                                        </p>
                                    </div>
                                @endif
                            @endif

                            @if($event->hasUserRegistered())
                                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                    <h3 class="text-lg font-semibold mb-2">Your Registration Status</h3>
                                    <div class="flex items-center">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="ml-2 px-2 py-1 rounded-full text-sm font-medium
                                            {{ $event->getUserRegistrationStatus() === 'attended' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($event->getUserRegistrationStatus()) }}
                                        </span>
                                    </div>
                                    @if($event->getUserRegistrationStatus() !== 'attended')
                                        <p class="text-sm text-gray-600 mt-2">
                                            Your attendance will be marked by the event organizer after the event.
                                        </p>
                                    @endif
                                </div>
                            @endif

                            @if($event->userCanRequestCertificate())
                                <form action="{{ route('certificates.request', $event) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded transition-colors duration-200">
                                        Request Certificate
                                    </button>
                                </form>
                            @elseif($event->hasUserRequestedCertificate())
                                <div class="bg-blue-50 border border-blue-200 rounded p-4">
                                    <p class="text-blue-700">Certificate Status: 
                                        <span class="font-medium">{{ ucfirst($event->getUserCertificateStatus()) }}</span>
                                    </p>
                                    @if($event->getUserCertificateStatus() === 'approved')
                                        <a href="{{ route('certificates.download', $event->getUserCertificate()) }}" 
                                           class="inline-block mt-2 text-blue-500 hover:text-blue-700">
                                            Download Certificate
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="mt-5">
                        <h1 class="font-bold text-3xl">Available Events:</h1>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-5">
                        @foreach($availableEvents as $event)
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
                        @endforeach
                    </div>
                    <div class="mt-6">
                        {{ $availableEvents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
