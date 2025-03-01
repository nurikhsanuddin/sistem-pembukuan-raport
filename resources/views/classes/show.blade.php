<table id="classes-table" class="w-full text-sm text-left">
    <thead>
        <tr>
            <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Nama Kelas</th>
            <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Tahun Akademik</th>
            <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($classes as $class)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $class->name }}</td>
                <td class="px-6 py-4">{{ $class->academic_year }}</td>
                <td class="px-6 py-4">
                    <div class="flex space-x-2">
                        <a href="{{ route('classes.edit', $class) }}"
                            class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Edit
                        </a>
                        <form action="{{ route('classes.destroy', $class) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@push('scripts')
    @include('components.datatable-config')
    <script>
        $(document).ready(function() {
            $('#classes-table').DataTable(defaultDataTableConfig);
        });
    </script>
@endpush
