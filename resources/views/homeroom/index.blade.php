<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Homeroom Teachers') }}
            </h2>
            <a href="{{ route('homeroom.create') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                Add New Teacher
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6">
                    <table id="teachers-table" class="w-full text-sm text-left">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Name</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">NIP</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Class</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Contact</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teachers as $teacher)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $teacher->name }}</td>
                                    <td class="px-6 py-4">{{ $teacher->nip }}</td>
                                    <td class="px-6 py-4">{{ $teacher->schoolClass->name }}</td>
                                    <td class="px-6 py-4">
                                        @if ($teacher->email)
                                            {{ $teacher->email }}<br>
                                        @endif
                                        @if ($teacher->phone)
                                            {{ $teacher->phone }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 space-x-2">
                                        <a href="{{ route('homeroom.edit', $teacher->id) }}"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 rounded hover:bg-yellow-700">
                                            Edit
                                        </a>
                                        <form action="{{ route('homeroom.destroy', $teacher->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700">
                                                Delete
                                            </button>
                                        </form>
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
                $('#teachers-table').DataTable(defaultDataTableConfig);
            });
        </script>
    @endpush
</x-app-layout>
