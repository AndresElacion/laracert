<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-6">
                        <h2 class="text-2xl font-bold">Coordinators</h2>
                        <a href="{{ url('coordinators/create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            Add Coordinator
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 text-left">#</th>
                                    <th class="px-6 py-3 text-left">Name</th>
                                    <th class="px-6 py-3 text-left">Events Count</th>
                                    <th class="px-6 py-3 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($coordinators as $coordinator)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{ $coordinator->name }}</td>
                                        <td class="px-6 py-4">{{ $coordinator->events_count }}</td>
                                        <td class="px-6 py-4 flex gap-2">
                                            <a href="{{ url('coordinators/'.$coordinator->id.'/edit') }}" 
                                               class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600">
                                                Edit
                                            </a>
                                            <form action="{{ url('coordinators/'.$coordinator->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600"
                                                        onclick="return confirm('Are you sure you want to delete this coordinator?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center">No coordinators found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $coordinators->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>