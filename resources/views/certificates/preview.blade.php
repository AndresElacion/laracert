<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4 flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-800">Certificate Preview</h2>
                        <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-200 rounded-md text-gray-700 hover:bg-gray-300">
                            Back
                        </a>
                    </div>
                    
                    <div class="border rounded-lg p-8 bg-gray-50">
                        <!-- Certificate Preview -->
                        <div class="bg-white shadow-lg mx-auto w-full relative"
                            style="
                                background-image: url('{{ asset('storage/' . ($certificate->eventRegistration->event->certificate_template ?? 
                                    $certificate->eventRegistration->event->certificateTemplateCategory->certificate_template ?? '')) }}'); 
                                background-size: contain;
                                background-repeat: no-repeat;
                                background-position: center;
                                aspect-ratio: 1.414/1;
                            ">
                            <!-- Remove flex and use absolute positioning for precise control -->
                            <div class="absolute inset-0">
                                <div class="relative h-full">
                                    <!-- Certificate Content -->
                                    <div class="text-center" style="padding-top: 32%; padding-right: 19%;"> <!-- Adjust this percentage to move content up/down -->
                                        <!-- Name section -->
                                        <div>
                                            <p class="text-3xl font-bold mb-8">
                                                {{ $certificate->eventRegistration->user->first_name }} {{ $certificate->eventRegistration->user->middle_name }} {{ $certificate->eventRegistration->user->last_name }}
                                            </p>
                                            <p class="text-xl font-bold">{{ $certificate->eventRegistration->event->description }} {{ $certificate->eventRegistration->event->name }}</p>
                                            <p class="text-xl font-bold">{{ $certificate->eventRegistration->event->event_date->format('F d, Y') }}</p>
                                        </div>

                                        <!-- Signatures -->
                                        <div class="relative mt-24">
                                            @foreach($certificate->eventRegistration->event->coordinators as $index => $coordinator)
                                                <div class="absolute signature" 
                                                    style="
                                                        {{ $index === 0 ? 'top: 40px; left: 23%;' : '' }}
                                                        {{ $index === 1 ? 'top: 40px; right: 23%;' : '' }}
                                                        {{ $index === 2 ? 'top: 0; left: 50%; transform: translateX(-50%);' : '' }}
                                                        {{ $index === 3 ? 'bottom: 0; left: 23%;' : '' }}
                                                        {{ $index === 4 ? 'bottom: 0; right: 23%;' : '' }}
                                                    ">
                                                    <div class="signature-line border-b border-black w-40 mx-auto"></div>
                                                    <p class="coordinator-name text-lg font-bold">{{ $coordinator->name }}</p>
                                                    <p class="coordinator-title italic text-sm">{{ $coordinator->title }}</p>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>