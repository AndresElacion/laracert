<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Status Filter Buttons -->
                    <div class="mb-6 space-x-4">
                        <a href="{{ route('dashboard', ['status' => 'pending']) }}" 
                           class="px-4 py-2 rounded-md {{ request('status') == 'pending' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                            Pending Requests
                        </a>
                        <a href="{{ route('dashboard', ['status' => 'approved']) }}"
                           class="px-4 py-2 rounded-md {{ request('status') == 'approved' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                            Approved Requests
                        </a>
                        <a href="{{ route('dashboard', ['status' => 'denied']) }}"
                           class="px-4 py-2 rounded-md {{ request('status') == 'denied' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                            Denied Requests
                        </a>
                    </div>

                    <!-- Certificates Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requested Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($certificateRequests as $request)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->eventRegistration->event->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $request->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                                   ($request->status === 'denied' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                            @if($request->status === 'approved')
                                                <a href="{{ route('certificates.preview', ['certificate' => $request->id]) }}"
                                                   class="text-blue-600 hover:text-blue-900 mr-2">
                                                    View Certificate
                                                </a>
                                                @if(!$request->downloaded_at)
                                                    <a href="{{ route('certificates.download', ['certificate' => $request->id]) }}"
                                                       class="text-blue-600 hover:text-blue-900">
                                                        Download Certificate
                                                    </a>
                                                @else
                                                    <span class="text-gray-500">Certificate Downloaded</span>
                                                @endif
                                            @elseif($request->status === 'pending')
                                                <a href="{{ route('certificates.preview', ['certificate' => $request->id]) }}"
                                                   class="text-blue-600 hover:text-blue-900 mr-2">
                                                    Preview Certificate
                                                </a>
                                                <span class="text-yellow-600">Pending Review</span>
                                            @else
                                                <span class="text-red-600">Request Denied</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            No certificate requests found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $certificateRequests->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>