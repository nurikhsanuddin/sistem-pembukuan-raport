{{-- @dump($reportCard->reportDetails) --}}
<table id="scores-table" class="w-full text-sm text-left">
    <thead>
        <tr>
            <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Nilai</th>
            <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Predikat</th>
            <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Deskripsi</th>
            <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">action</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($predikats as $predikat)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $predikat->nilai_min }} - {{ $predikat->nilai_max }} </td>
                <td class="px-6 py-4">{{ $predikat->predikat }}</td>
                <td class="px-6 py-4">{{ $predikat->deskripsi }}</td>
                <td class="px-6 py-4">
                    <div class="flex space-x-2">
                        <a href="{{ route('predikat.edit', $predikat) }}"
                            class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Edit
                        </a>
                        <form action="{{ route('predikat.destroy', $predikat) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus predikat ini?')">
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
            $('#scores-table').DataTable(defaultDataTableConfig);
        });
    </script>
@endpush
