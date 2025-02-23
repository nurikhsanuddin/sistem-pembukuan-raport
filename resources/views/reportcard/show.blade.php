<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Report Card - {{ $reportCard->student->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6">
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex items-center">
                            <span class="font-medium mr-2">Class:</span> 
                            {{ $reportCard->schoolClass->name }}
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium mr-2">Semester:</span>
                            {{ $reportCard->semester->name }}
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium mr-2">Academic Year:</span>
                            {{ $reportCard->semester->academic_year }}
                        </div>
                    </div>

                    <table id="scores-table" class="w-full text-sm text-left">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Subject</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Knowledge Score</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Skill Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportCard->reportDetails as $detail)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $detail->subject->name }}</td>
                                <td class="px-6 py-4">{{ $detail->score_knowledge }}</td>
                                <td class="px-6 py-4">{{ $detail->score_skill }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6">
                        <a href="{{ url()->previous() }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @include('components.datatable-config')
    <script>
        $(document).ready(function() {
            $('#scores-table').DataTable(defaultDataTableConfig);
        });
    </script>
    @endpush
</x-app-layout>
