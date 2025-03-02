<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Raport {{ $student->name }}</title>
    <style>
        body {
            font-family: courier;
            font-size: 10pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 0.5px solid #000;
            padding: 3px;
        }

        th {
            background: #eee;
        }

        h3 {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <h3>LAPORAN HASIL BELAJAR SISWA</h3>
    <p>{{ $class->name }} - {{ $class->academic_year }}</p>

    <table>
        <tr>
            <td width="25%">Nama Siswa</td>
            <td width="75%">{{ $student->name }}</td>
        </tr>
        <tr>
            <td>NIS</td>
            <td>{{ $student->student_no }}</td>
        </tr>
        <tr>
            <td>NISN</td>
            <td>{{ $student->nisn }}</td>
        </tr>
        <tr>
            <td>Wali Kelas</td>
            <td>{{ $homeroomTeacher->name ?? 'Tidak ada' }}</td>
        </tr>
    </table>

    <br>

    <table>
        <tr>
            <th>No</th>
            <th>Mapel</th>
            <th>Nilai Pengetahuan</th>
            <th>Nilai Keterampilan</th>
        </tr>

        @php
            $no = 1;
            $total_knowledge = 0;
            $total_skill = 0;
            $count = 0;
        @endphp

        @foreach ($grouped_subjects as $group => $details)
            <tr>
                <td colspan="4" style="background: #eee; font-weight: bold;">{{ $group }}</td>
            </tr>

            @foreach ($details as $detail)
                @php
                    $total_knowledge += $detail->score_knowledge;
                    $total_skill += $detail->score_skill;
                    $count++;
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $detail->description }}</td>
                    <td>{{ $detail->score_knowledge }}</td>
                    <td>{{ $detail->score_skill }}</td>
                </tr>
            @endforeach
        @endforeach

        <tr>
            <th colspan="2">Total</th>
            <th>{{ $total_knowledge }}</th>
            <th>{{ $total_skill }}</th>
        </tr>
        <tr>
            <th colspan="2">Rata-rata</th>
            <th>{{ number_format($total_knowledge / ($count ?: 1), 2) }}</th>
            <th>{{ number_format($total_skill / ($count ?: 1), 2) }}</th>
        </tr>
    </table>

    <br><br>

    <table border="0">
        <tr>
            <td style="width: 60%; border: none;"></td>
            <td style="width: 40%; border: none; text-align: center;">
                Wali Kelas<br><br><br><br>
                {{ $homeroomTeacher->name ?? '...................' }}<br>
                NIP: {{ $homeroomTeacher->nip ?? '...................' }}
            </td>
        </tr>
    </table>
</body>

</html>
