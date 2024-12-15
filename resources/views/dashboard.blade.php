<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Status Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <a href="{{ route('dashboard', ['status' => 'pending']) }}"
                   class="transform transition-transform hover:scale-105">
                    <div class="relative overflow-hidden rounded-xl border p-6 bg-blue-100 border-blue-200">
                        <div class="flex items-center gap-4">
                            <div class="p-3 rounded-full {{ request('status') == 'pending' ? 'bg-blue-100' : 'bg-gray-100' }}">
                                <svg class="w-6 h-6 {{ request('status') == 'pending' ? 'text-blue-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Pending Requests</p>
                                <p class="text-2xl font-semibold {{ request('status') == 'pending' ? 'text-blue-600' : 'text-gray-900' }}">
                                    {{ $counts['pending'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('dashboard', ['status' => 'approved']) }}"
                   class="transform transition-transform hover:scale-105">
                    <div class="relative overflow-hidden rounded-xl border p-6 bg-green-100 border-green-200">
                        <div class="flex items-center gap-4">
                            <div class="p-3 rounded-full {{ request('status') == 'approved' ? 'bg-green-100' : 'bg-gray-100' }}">
                                <svg class="w-6 h-6 {{ request('status') == 'approved' ? 'text-green-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Approved Requests</p>
                                <p class="text-2xl font-semibold {{ request('status') == 'approved' ? 'text-green-600' : 'text-gray-900' }}">
                                    {{ $counts['approved'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('dashboard', ['status' => 'denied']) }}"
                   class="transform transition-transform hover:scale-105">
                    <div class="relative overflow-hidden rounded-xl border p-6 bg-red-100 border-red-200">
                        <div class="flex items-center gap-4">
                            <div class="p-3 rounded-full {{ request('status') == 'denied' ? 'bg-red-100' : 'bg-gray-100' }}">
                                <svg class="w-6 h-6 {{ request('status') == 'denied' ? 'text-red-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2sm-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Denied Requests</p>
                                <p class="text-2xl font-semibold {{ request('status') == 'denied' ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $counts['denied'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <form action="{{ route('admin.dashboard.certificates.bulkAction') }}" method="POST">
                @csrf

                <div class="flex justify-end mb-2">
                    <button type="submit" name="action" value="download" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download Selected
                    </button>
                </div>

                <!-- Main Content -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-x-auto">
                    <!-- Desktop Table -->
                    <div class="hidden sm:block">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        {{-- <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"> --}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Event</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Requested Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($certificateRequests as $request)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <input type="checkbox" name="certificates[]" value="{{ $request->id }}" 
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            #{{ $request->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $request->eventRegistration->event->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $request->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                                ($request->status === 'denied' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $request->created_at->format('M d, Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-3">
                                            @if($request->status === 'approved')
                                                <a href="{{ route('certificates.preview', ['certificate' => $request->id]) }}"
                                                class="inline-flex items-center text-blue-600 hover:text-blue-900">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    View
                                                </a>
                                                @if(!$request->downloaded_at)
                                                    <a href="{{ route('certificates.download', ['certificate' => $request->id]) }}"
                                                    class="inline-flex items-center text-blue-600 hover:text-blue-900">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                        </svg>
                                                        Download
                                                    </a>
                                                @else
                                                    <span class="inline-flex items-center text-gray-500">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Downloaded
                                                    </span>
                                                @endif
                                            @elseif($request->status === 'pending')
                                                <a href="{{ route('certificates.preview', ['certificate' => $request->id]) }}"
                                                class="inline-flex items-center text-blue-600 hover:text-blue-900">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    Preview
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <p class="text-gray-500 text-lg font-medium">No certificate requests found</p>
                                                <p class="text-gray-400 text-sm mt-1">Certificate requests will appear here once created</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="sm:hidden divide-y divide-gray-200">
                        @forelse ($certificateRequests as $request)
                            <div class="p-6 space-y-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">#{{ $request->id }}</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $request->eventRegistration->event->name }}</p>
                                    </div>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $request->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                        ($request->status === 'denied' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    {{ $request->created_at->format('M d, Y H:i') }}
                                </div>
                                <div class="flex flex-col space-y-2">
                                    @if($request->status === 'approved')
                                        <a href="{{ route('certificates.preview', ['certificate' => $request->id]) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 border border-blue-600 rounded-md text-sm font-medium text-blue-600 bg-white hover:bg-blue-50 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View Certificate
                                        </a>
                                        @if(!$request->downloaded_at)
                                            <a href="{{ route('certificates.download', ['certificate' => $request->id]) }}"
                                            class="inline-flex items-center justify-center px-4 py-2 border border-blue-600 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
                                                Download Certificate
                                            </a>
                                        @else
                                            <div class="inline-flex items-center justify-center px-4 py-2 border border-gray-200 rounded-md text-sm font-medium text-gray-500 bg-gray-50">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Already Downloaded
                                            </div>
                                        @endif
                                    @elseif($request->status === 'pending')
                                        <a href="{{ route('certificates.preview', ['certificate' => $request->id]) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 border border-blue-600 rounded-md text-sm font-medium text-blue-600 bg-white hover:bg-blue-50 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Preview Request
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium">No certificate requests found</p>
                                    <p class="text-gray-400 text-sm mt-1">Certificate requests will appear here once created</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($certificateRequests->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                            {{ $certificateRequests->links() }}
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-app-layout>