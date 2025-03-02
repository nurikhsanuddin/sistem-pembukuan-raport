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
                            {{ $reportCard->semester->number }}
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium mr-2">Academic Year:</span>
                            {{ $reportCard->schoolClass->academic_year }}
                        </div>
                        <!-- Add Homeroom Teacher Info -->
                        <div class="flex items-center">
                            <span class="font-medium mr-2">Homeroom Teacher:</span>
                            {{ $reportCard->schoolClass->homeroomTeacher->name ?? 'Not assigned' }}
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium mr-2">NIP:</span>
                            {{ $reportCard->schoolClass->homeroomTeacher->nip ?? '-' }}
                        </div>
                    </div>
                    {{-- @dump($reportCard->reportDetails) --}}
                    <table id="scores-table" class="w-full text-sm text-left">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Mapel</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Nilai Pengetahuan</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Predikat Pengetahuan</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Deskripsi Pengetahuan</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Skill Keterampilan</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Predikat Keterampilan</th>
                                <th class="px-6 py-3 bg-gray-50 font-medium text-gray-900">Deskripsi Keterampilan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_knowledge_score = 0;
                            $total_skill_score = 0;
                            $grouped_subjects = [];
                            
                            // Group the subjects
                            foreach ($reportCard->reportDetails as $detail) {
                                $subject_name = $detail->subject->name;
                                if (str_contains(strtoupper($subject_name), 'PAI')) {
                                    $group = 'PAI';
                                } elseif (str_contains(strtoupper($subject_name), 'MULOK')) {
                                    $group = 'Muatan Lokal';
                                } else {
                                    $group = 'Umum';
                                }
                                $grouped_subjects[$group][] = $detail;
                            }
                            ?>

                            @foreach ($grouped_subjects as $group => $details)
                                <tr class="bg-gray-100">
                                    <td colspan="7" class="px-6 py-3 font-bold">{{ $group }}</td>
                                </tr>
                                @foreach ($details as $detail)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $detail->subject->description }}</td>
                                        <td class="px-6 py-4">{{ $detail->score_knowledge }}</td>
                                        <td class="px-6 py-4">
                                            @foreach ($predikat as $grade)
                                                @if ($detail->score_knowledge >= $grade->nilai_min && $detail->score_knowledge <= $grade->nilai_max)
                                                    {{ $grade->predikat }}
                                                    @php $knowledge_grade = $grade->predikat; @endphp
                                                    @break
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4">
                                            @if (isset($knowledge_grade))
                                                @switch($knowledge_grade)
                                                    @case('A')
                                                        {{ $detail->subject->pengetahuan_A ?? 'Silahkan tambah deskripsi di menu mapel' }}
                                                    @break

                                                    @case('B')
                                                        {{ $detail->subject->pengetahuan_B ?? 'Silahkan tambah deskripsi di menu mapel' }}
                                                    @break

                                                    @case('C')
                                                        {{ $detail->subject->pengetahuan_C ?? 'Silahkan tambah deskripsi di menu mapel' }}
                                                    @break

                                                    @case('D')
                                                        {{ $detail->subject->pengetahuan_D ?? 'Silahkan tambah deskripsi di menu mapel' }}
                                                    @break
                                                @endswitch
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $detail->score_skill }}</td>
                                        <td class="px-6 py-4">
                                            @foreach ($predikat as $grade)
                                                @if ($detail->score_skill >= $grade->nilai_min && $detail->score_skill <= $grade->nilai_max)
                                                    {{ $grade->predikat }}
                                                    @php $skill_grade = $grade->predikat; @endphp
                                                    @break
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4">
                                            @if (isset($skill_grade))
                                                @switch($skill_grade)
                                                    @case('A')
                                                        {{ $detail->subject->keterampilan_A ?? 'Silahkan tambah deskripsi di menu mapel' }}
                                                    @break

                                                    @case('B')
                                                        {{ $detail->subject->keterampilan_B ?? 'Silahkan tambah deskripsi di menu mapel' }}
                                                    @break

                                                    @case('C')
                                                        {{ $detail->subject->keterampilan_C ?? 'Silahkan tambah deskripsi di menu mapel' }}
                                                    @break

                                                    @case('D')
                                                        {{ $detail->subject->keterampilan_D ?? 'Silahkan tambah deskripsi di menu mapel' }}
                                                    @break
                                                @endswitch
                                            @endif
                                        </td>
                                    </tr>
                                    <?php
                                    $total_knowledge_score += $detail->score_knowledge;
                                    $total_skill_score += $detail->score_skill;
                                    ?>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-6 bg-white rounded-lg shadow-md border border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-800">Knowledge Score</h3>
                                <span class="text-2xl font-bold text-blue-600">{{ $total_knowledge_score }}</span>
                            </div>
                        </div>
                        <div class="p-6 bg-white rounded-lg shadow-md border border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-800">Skill Score</h3>
                                <span class="text-2xl font-bold text-green-600">{{ $total_skill_score }}</span>
                            </div>
                        </div>
                    </div>
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
                $('#scores-table').DataTable({
                    ...defaultDataTableConfig,
                    columnDefs: [{
                        "targets": "_all", // Apply to all columns
                        "type": "string", // Treat all columns as string type
                        "defaultContent": "" // Default value for empty cells
                    }],
                    orderCellsTop: true, // Enable sorting on header row only
                    order: [], // Disable initial sorting
                });
            });
        </script>
    @endpush
</x-app-layout>
