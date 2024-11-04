<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.certificates.bulkAction') }}" method="POST">
                @csrf
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between mb-4">
                        <h2 class="text-xl font-semibold">Certificate Requests</h2>
                        <div class="flex gap-2">
                            <button type="submit" name="action" value="approve" 
                                class="bg-green-500 text-white px-4 py-2 rounded">
                                Approve Selected
                            </button>
                            <button type="submit" name="action" value="deny" 
                                class="bg-red-500 text-white px-4 py-2 rounded">
                                Deny Selected
                            </button>
                            <button type="submit" name="action" value="download" 
                                class="bg-blue-500 text-white px-4 py-2 rounded">
                                Download Selected
                            </button>
                        </div>
                    </div>

                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th>User</th>
                                <th>Event</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($certificates as $request)
                            <tr class="text-center">
                                <td>
                                    <input type="checkbox" name="certificates[]" 
                                        value="{{ $request->id }}">
                                </td>
                                <td>{{ $request->eventRegistration->user->name }}</td>
                                <td>{{ $request->eventRegistration->event->name }}</td>
                                <td>{{ $request->created_at->format('Y-m-d') }}</td>
                                <td>{{ $request->status }}</td>
                                <td>
                                    <a href="{{ route('certificates.download', ['certificate' => $request->id]) }}">Download Certificate</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>