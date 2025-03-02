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
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('homeroom.edit', $teacher->id) }}"
                                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                Edit
                            </a>
                            <form action="{{ route('homeroom.destroy', $teacher->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this teacher?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('scripts')
    @include('components.datatable-config')
    <script>
        $(document).ready(function() {
            $('#teachers-table').DataTable(defaultDataTableConfig);
        });
    </script>
@endpush
