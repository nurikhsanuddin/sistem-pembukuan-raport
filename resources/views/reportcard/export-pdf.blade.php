<!DOCTYPE html>
<html>

<head>
    @php
        use App\Models\Predikat;
    @endphp
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Raport Siswa - {{ $class->name }}</title>
    <style>
        @page {
            margin: 2cm;
            size: A4;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .page-break {
            page-break-after: always;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 1.5px solid #333;
            padding-bottom: 10px;
        }

        .header img {
            width: 70px;
            height: auto;
            margin-bottom: 8px;
        }

        .header h3 {
            margin: 5px 0;
            font-size: 16pt;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #000;
        }

        .header h4 {
            margin: 5px 0;
            font-size: 13pt;
            font-weight: normal;
        }

        .student-info {
            margin-bottom: 20px;
            background-color: #f8f8f8;
            padding: 12px;
            border-radius: 3px;
            border-left: 3px solid #555;
        }

        .student-info table {
            width: 100%;
            border: none;
        }

        .student-info td {
            padding: 5px;
            border: none;
            vertical-align: top;
        }

        .grades table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .grades th,
        .grades td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }

        .grades th {
            background-color: #e6e6e6;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
        }

        .signatures {
            width: 100%;
            margin-top: 50px;
            margin-bottom: 20px;
        }

        .signatures table {
            width: 100%;
            border-collapse: collapse;
        }

        .signatures td {
            width: 33.33%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }

        .signature-line {
            margin: 50px auto 5px;
            width: 80%;
            border-bottom: 1px solid #000;
        }

        .grade-info {
            margin: 20px 0;
            border: 1px solid #333;
            padding: 10px;
        }

        .grade-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .grade-info th,
        .grade-info td {
            border: 1px solid #333;
            padding: 5px;
            text-align: center;
        }

        .summary {
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #333;
            background-color: #f8f8f8;
        }

        .summary h4 {
            margin-top: 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary td {
            padding: 5px;
        }

        .descriptions {
            margin-top: 20px;
        }

        .descriptions table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .descriptions th,
        .descriptions td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
            font-size: 10pt;
        }

        .descriptions th {
            background-color: #e6e6e6;
            font-weight: bold;
        }
    </style>
</head>

<body>
    @foreach ($class->students as $student)
        <div class="header">
            <img src="{{ public_path('logo.png') }}" alt="Logo Sekolah">
            <h3>LAPORAN HASIL BELAJAR SISWA</h3>
            <h4>{{ $class->name }} - Tahun Ajaran {{ $class->academic_year }}</h4>
        </div>

        <div class="student-info">
            <table>
                <tr>
                    <td width="25%">Nama Siswa</td>
                    <td width="2%">:</td>
                    <td>{{ $student->name }}</td>
                </tr>
                <tr>
                    <td>NIS</td>
                    <td>:</td>
                    <td>{{ $student->student_no }}</td>
                </tr>
                <tr>
                    <td>NISN</td>
                    <td>:</td>
                    <td>{{ $student->nisn }}</td>
                </tr>
                <tr>
                    <td>Wali Kelas</td>
                    <td>:</td>
                    <td>
                        @if (isset($class->homeroomTeacher))
                            {{ $class->homeroomTeacher->name }}
                        @else
                            @php
                                $teacherId = $class->homeroom_teacher_id ?? 'null';
                                echo "Belum ditentukan (ID: $teacherId)";
                            @endphp
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td>{{ $class->homeroomTeacher->nip ?? '-' }}</td>
                </tr>
            </table>
        </div>

        @if ($student->reportCards->isNotEmpty())
            @php
                $reportCard = $student->reportCards->first();
                $totalKnowledge = 0;
                $totalSkill = 0;
                $subjectCount = 0;
            @endphp

            <div class="grades">
                <table>
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Mata Pelajaran</th>
                            <th colspan="2">Nilai</th>
                            <th colspan="2">Predikat</th>
                        </tr>
                        <tr>
                            <th>Pengetahuan</th>
                            <th>Keterampilan</th>
                            <th>Pengetahuan</th>
                            <th>Keterampilan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reportCard->reportDetails as $index => $detail)
                            @php
                                $totalKnowledge += $detail->score_knowledge;
                                $totalSkill += $detail->score_skill;
                                $subjectCount++;

                                $knowledgeGrade = $detail->knowledgePredicate;
                                $skillGrade = $detail->skillPredicate;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td style="text-align: left">{{ $detail->subject->description }}</td>
                                <td>{{ $detail->score_knowledge }}</td>
                                <td>{{ $detail->score_skill }}</td>
                                <td>{{ $knowledgeGrade ? $knowledgeGrade->predikat : '' }}</td>
                                <td>{{ $skillGrade ? $skillGrade->predikat : '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="page-break"></div>

            <div class="header">
                <h3>DESKRIPSI NILAI</h3>
                <h4>{{ $student->name }} - {{ $class->name }}</h4>
            </div>

            <div class="descriptions">
                <table>
                    <thead>
                        <tr>
                            <th>Mata Pelajaran</th>
                            <th>Pengetahuan</th>
                            <th>Keterampilan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reportCard->reportDetails as $detail)
                            <tr>
                                <td>{{ $detail->subject->description }}</td>
                                <td>
                                    @php $knowledge_grade = optional($detail->knowledgePredicate)->predikat; @endphp
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
                                </td>
                                <td>
                                    @php $skill_grade = optional($detail->skillPredicate)->predikat; @endphp
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Summary section -->
            <div class="summary">
                <h4>Ringkasan Nilai:</h4>
                <table>
                    <tr>
                        <td width="200">Total Nilai Pengetahuan</td>
                        <td width="20">:</td>
                        <td>{{ $totalKnowledge }}</td>
                    </tr>
                    <tr>
                        <td>Total Nilai Keterampilan</td>
                        <td>:</td>
                        <td>{{ $totalSkill }}</td>
                    </tr>
                    <tr>
                        <td>Rata-rata Pengetahuan</td>
                        <td>:</td>
                        <td>{{ number_format($totalKnowledge / $subjectCount, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Rata-rata Keterampilan</td>
                        <td>:</td>
                        <td>{{ number_format($totalSkill / $subjectCount, 2) }}</td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                <div class="signatures">
                    <table>
                        <tr>
                            <td>
                                <p>Mengetahui,<br>Kepala Sekolah</p>
                                <div class="signature-line"></div>
                                <p>NIP.</p>
                            </td>
                            <td>
                                @php
                                    // Direct implementation to fix the immediate issue
                                    $date = now();
                                    $indonesianMonths = [
                                        'Januari',
                                        'Februari',
                                        'Maret',
                                        'April',
                                        'Mei',
                                        'Juni',
                                        'Juli',
                                        'Agustus',
                                        'September',
                                        'Oktober',
                                        'November',
                                        'Desember',
                                    ];
                                    $formattedDate =
                                        $date->day . ' ' . $indonesianMonths[$date->month - 1] . ' ' . $date->year;
                                @endphp
                                <p>{{ $formattedDate }}<br>Wali Kelas</p>
                                <div class="signature-line"></div>
                                <p>{{ $class->homeroomTeacher->name ?? '...........................' }}<br>
                                    NIP. {{ $class->homeroomTeacher->nip ?? '..................' }}</p>
                            </td>
                            <td>
                                <p>Orang Tua/Wali</p>
                                <div class="signature-line"></div>
                                <p>.............................</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        @endif

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>
