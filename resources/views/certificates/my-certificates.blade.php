<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-4">My Certificates</h2>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">Event</th>
                                    <th class="px-4 py-2">Request Date</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($certificates as $certificate)
                                <tr class="text-center">
                                    <td class="border px-4 py-2">
                                        {{ $certificate->eventRegistration->event->name }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ $certificate->created_at->format('F d, Y') }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        <span class="px-2 py-1 rounded text-sm
                                            @if($certificate->status === 'approved') bg-green-100 text-green-800
                                            @elseif($certificate->status === 'denied') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800
                                            @endif">
                                            {{ ucfirst($certificate->status) }}
                                        </span>
                                    </td>
                                    <td class="border px-4 py-2">
                                        @if($certificate->status === 'approved')
                                            @if(!$certificate->downloaded_at)
                                                <a href="{{ route('certificates.download', $certificate) }}" 
                                                class="text-blue-500 hover:text-blue-700">
                                                    Download
                                                </a>
                                            @else
                                                <span class="text-gray-500">Certificate Downloaded</span>
                                            @endif
                                        @elseif($certificate->status === 'denied')
                                            <span class="text-red-500" title="{{ $certificate->denial_reason }}">
                                                View Reason
                                            </span>
                                        @else
                                            <span class="text-gray-500">Pending Review</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $certificates->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>