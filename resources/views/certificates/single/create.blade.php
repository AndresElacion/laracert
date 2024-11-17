<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Generate Certificate for {{ $user->first_name }} {{ $user->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form id="certificateForm" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="event_id">Select Event</label>
                            <select id="event_id" name="event_id" class="block mt-1 w-full rounded-md border-gray-300">
                                <option value="">Select an event</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}">
                                        {{ $event->name }} ({{ $event->event_date->format('M d, Y') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="certificate_date">Certificate Date</label>
                            <input id="certificate_date" type="date" name="certificate_date" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required />
                        </div>

                        <div>
                            <label for="remarks">Remarks (Optional)</label>
                            <textarea id="remarks" name="remarks" 
                                    class="block mt-1 w-full rounded-md border-gray-300"></textarea>
                        </div>

                        <div class="flex space-x-4">
                            <button type="button" onclick="previewCertificate()" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded transition-colors duration-200">
                                Preview Certificate
                            </button>
                            <button type="button" onclick="generateCertificate()" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded transition-colors duration-200">
                                Generate Certificate
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getFormData() {
            return {
                event_id: document.getElementById('event_id').value,
                certificate_date: document.getElementById('certificate_date').value,
                remarks: document.getElementById('remarks').value,
                _token: document.querySelector('input[name="_token"]').value
            };
        }

        function previewCertificate() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('users.certificate.preview', $user->id) }}';
            form.target = '_blank';

            const formData = getFormData();
            for (const key in formData) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = formData[key];
                form.appendChild(input);
            }

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }

        function generateCertificate() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('users.certificate.generate', $user->id) }}';

            const formData = getFormData();
            for (const key in formData) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = formData[key];
                form.appendChild(input);
            }

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    </script>
</x-app-layout>