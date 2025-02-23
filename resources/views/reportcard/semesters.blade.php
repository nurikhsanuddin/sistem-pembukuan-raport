<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Semesters for') }} {{ $student->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6">
                    <table id="semesters-table" class="w-full text-sm text-left">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Semester</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Academic Year</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semesters as $reportCard)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $reportCard->semester->number }}</td>
                                <td class="px-6 py-4">{{ $reportCard->schoolClass->academic_year }}</td>
                                <td class="px-6 py-4 space-x-2">
                                    <a href="{{ route('report-cards.show', [$student->id, $reportCard->semester_id]) }}" 
                                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                                        View
                                    </a>
                                    <button onclick="deleteReportCard({{ $reportCard->id }})"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @include('components.datatable-config')
    <script>
        $(document).ready(function() {
            $('#semesters-table').DataTable(defaultDataTableConfig);
        });

        function deleteReportCard(id) {
            if (confirm('Are you sure you want to delete this report card?')) {
                $.ajax({
                    url: `/report-cards/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Error deleting report card');
                        }
                    }
                });
            }
        }
    </script>
    @endpush
</x-app-layout>
