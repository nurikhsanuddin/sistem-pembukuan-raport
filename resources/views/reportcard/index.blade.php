<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Report Cards') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6">
                    <table id="students-table" class="w-full text-sm text-left">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Student No</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Name</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Current Class</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @include('components.datatable-config')
    <script>
        $(document).ready(function() {
            $('#students-table').DataTable({
                ...defaultDataTableConfig,
                ajax: {
                    url: "{{ route('api.students.list') }}",
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'student_no' },
                    { data: 'name' },
                    { data: 'class_name' },
                    {
                        data: 'id',
                        render: function(data) {
                            return `<a href="/report-cards/${data}/semesters" 
                                      class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                                      Details
                                   </a>`;
                        }
                    }
                ]
            });
        });
    </script>
    @endpush
</x-app-layout>
