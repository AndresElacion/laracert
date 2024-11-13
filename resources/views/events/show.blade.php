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
                                {{ $event->event_date->format('F d, Y - h:i A') }}
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            @if($event->event_date->isPast())
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">Past Event</span>
                            @else
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">Upcoming</span>
                            @endif

                            @if (auth()->user()->is_admin)
                                <a href="{{ route('events.edit', $event) }}" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit Event
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="prose max-w-none mb-8">
                        <p class="text-gray-600 mb-4">{!! nl2br($event->description) !!}</p>
                    </div>

                    
                    @if(isset($event->coordinators))
                        <div class="grid grid-cols-2">
                            @foreach($event->coordinators as $coordinator)
                            <div class="flex items-center space-x-2 text-gray-600 line-clamp-3">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v2h20v-2c0-3.3-6.7-5-10-5z"/>
                                </svg>
                                    <p class="text-gray-600 line-clamp-3">{{ $coordinator->name }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4">Registration & Certificate Status</h3>
                        
                        <div class="space-y-4">
                            @if(!$event->event_date->isPast())
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

                    @if (auth()->user()->is_admin)
                        <div class="border-t mt-8 pt-6">
                            <h3 class="text-lg font-semibold mb-4">Administrative Actions</h3>
                            
                            <div class="space-y-4">
                                @if($event->certificate_template)
                                    <div class="flex items-center space-x-4">
                                        <p class="text-sm text-gray-600">Certificate Template: Uploaded</p>
                                        <a href="{{ route('events.download-template', $event) }}" 
                                           class="text-blue-500 hover:text-blue-700 text-sm">
                                            View Template
                                        </a>
                                    </div>
                                @endif

                                <form action="{{ route('events.update-template', $event) }}" 
                                      method="POST" 
                                      enctype="multipart/form-data" 
                                      class="space-y-4">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            Update Certificate Template
                                        </label>
                                        <input type="file" 
                                               name="certificate_template" 
                                               accept=".pdf"
                                               class="mt-1 block w-full text-sm text-gray-500
                                                      file:mr-4 file:py-2 file:px-4
                                                      file:rounded-full file:border-0
                                                      file:text-sm file:font-semibold
                                                      file:bg-blue-50 file:text-blue-700
                                                      hover:file:bg-blue-100">
                                    </div>
                                    
                                    <button type="submit" 
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm">
                                        Upload Template
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
