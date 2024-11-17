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
                                            <p class="text-xl">has successfully completed</p>
                                            <p class="text-2xl font-bold mt-4">{{ $certificate->eventRegistration->event->name }}</p>
                                        </div>

                                        <!-- Signatures -->
                                        <div style="margin-top: 3%">
                                            <div class="grid grid-cols-2 gap-8 max-w-2xl mx-auto">
                                                @foreach($coordinators->eventRegistration->event->coordinators as $index => $coordinator)
                                                <div class="text-center">
                                                    <div class="border-b border-black w-48 mx-auto"></div>
                                                    <p class="font-bold mt-1">{{ $coordinator->name }}</p>
                                                    <p class="italic">{{ $coordinator->title }}</p>
                                                </div>
                                                @endforeach
                                            </div>
                                            
                                            <!-- Date -->
                                            <div class="mt-8">
                                                <p class="text-sm">Issued on: {{ $certificate->created_at->format('F d, Y') }}</p>
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
    </div>
</x-app-layout>