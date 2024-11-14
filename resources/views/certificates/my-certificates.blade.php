<x-app-layout>
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    <!-- Header Section -->
                    <div class="space-y-2 mb-6 sm:mb-8">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">My Certificates</h2>
                        <p class="text-sm text-gray-500">Manage and download your event certificates</p>
                    </div>

                    <!-- Mobile View (Cards) and Desktop View (Table) -->
                    <div class="block sm:hidden space-y-4">
                        @foreach($certificates as $certificate)
                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                            <div class="p-4 space-y-4">
                                <!-- Event Name -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 line-clamp-2">
                                        {{ $certificate->eventRegistration->event->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $certificate->created_at->format('F d, Y') }}
                                    </p>
                                </div>

                                <!-- Status Badge -->
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($certificate->status === 'approved') bg-green-100 text-green-800
                                        @elseif($certificate->status === 'denied') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        <span class="h-2 w-2 mr-2 rounded-full
                                            @if($certificate->status === 'approved') bg-green-400
                                            @elseif($certificate->status === 'denied') bg-red-400
                                            @else bg-yellow-400
                                            @endif">
                                        </span>
                                        {{ ucfirst($certificate->status) }}
                                    </span>

                                    <!-- Action Buttons -->
                                    <div>
                                        @if($certificate->status === 'approved')
                                            @if(!$certificate->downloaded_at)
                                                <a href="{{ route('certificates.download', $certificate) }}" 
                                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                    Download
                                                </a>
                                            @else
                                                <span class="inline-flex items-center text-gray-500">
                                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    Downloaded
                                                </span>
                                            @endif
                                        @elseif($certificate->status === 'denied')
                                            <button type="button" 
                                                class="inline-flex items-center text-red-600 hover:text-red-900"
                                                onclick="alert('{{ $certificate->denial_reason }}')">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                View Reason
                                            </button>
                                        @else
                                            <span class="inline-flex items-center text-gray-500">
                                                <svg class="h-4 w-4 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                </svg>
                                                Pending
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Desktop Table View (Hidden on Mobile) -->
                    <div class="hidden sm:block">
                        <div class="bg-white rounded-lg border border-gray-200">
                            <div class="overflow-x-auto">
                                <!-- Existing table code remains the same -->
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request Date</th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($certificates as $certificate)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $certificate->eventRegistration->event->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">
                                                    {{ $certificate->created_at->format('F d, Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                    @if($certificate->status === 'approved') bg-green-100 text-green-800
                                                    @elseif($certificate->status === 'denied') bg-red-100 text-red-800
                                                    @else bg-yellow-100 text-yellow-800
                                                    @endif">
                                                    <span class="h-2 w-2 mr-2 rounded-full
                                                        @if($certificate->status === 'approved') bg-green-400
                                                        @elseif($certificate->status === 'denied') bg-red-400
                                                        @else bg-yellow-400
                                                        @endif">
                                                    </span>
                                                    {{ ucfirst($certificate->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                                @if($certificate->status === 'approved')
                                                    @if(!$certificate->downloaded_at)
                                                        <a href="{{ route('certificates.download', $certificate) }}" 
                                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                            </svg>
                                                            Download
                                                        </a>
                                                    @else
                                                        <span class="inline-flex items-center text-gray-500">
                                                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Downloaded
                                                        </span>
                                                    @endif
                                                @elseif($certificate->status === 'denied')
                                                    <button type="button" 
                                                        class="inline-flex items-center text-red-600 hover:text-red-900"
                                                        title="{{ $certificate->denial_reason }}">
                                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        View Reason
                                                    </button>
                                                @else
                                                    <span class="inline-flex items-center text-gray-500">
                                                        <svg class="h-4 w-4 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                        </svg>
                                                        Pending
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $certificates->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>