<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Student;
use App\Models\ReportCard;
use App\Models\ReportDetail;
use App\Models\Subject;

class PengetahuanSheetImport implements ToCollection, WithStartRow
{
    protected $semester_id;
    protected $class_id;
    protected $headers = [];
    protected $category = 'Pengetahuan';
    protected $scoreColumn = 'score_knowledge';

    // Add configuration arrays for PAI and MULOK subjects
    protected $paiSubjects = ['QH', 'AA', 'FIK', 'SKI'];
    protected $mulokSubjects = ['B.Jaw', 'Coba']; // Add your MULOK subjects here

    // Add this property to better track non-subject columns
    protected $nonSubjectColumns = [
        'NO',
        'NIS',
        'NISN',
        'NAMA',
        'JK',
        'JUMLAH',
        'no',
        'nis',
        'nisn',
        'nama',
        'jk',
        'jumlah'
    ];

    public function __construct($semester_id, $class_id)
    {
        $this->semester_id = $semester_id;
        $this->class_id = $class_id;
    }

    public function startRow(): int
    {
        return 6; // Mulai baca dari row 6 untuk proses header
    }

    protected function processHeaders(Collection $rows)
    {
        $row6 = $rows[0];
        $row7 = $rows[1];

        $headers = [];
        $currentGroup = null;
        $mulokStartIndex = null;

        foreach ($row6 as $index => $value) {
            $value = trim($value);
            if (!empty($value)) {
                if (in_array(strtoupper($value), $this->nonSubjectColumns)) {
                    $headers[$index] = strtolower($value);
                    continue;
                }

                if ($value === 'PAI') {
                    $currentGroup = 'PAI';
                } else if ($value === 'MULOK') {
                    $currentGroup = 'MULOK';
                    $mulokStartIndex = $index;  // Mark the start of MULOK section
                } else {
                    if ($currentGroup !== 'MULOK') {  // Only reset if not in MULOK section
                        $currentGroup = null;
                    }
                    if (!in_array(strtoupper($value), $this->nonSubjectColumns)) {
                        $headers[$index] = ['type' => 'REGULAR', 'name' => $value];
                    }
                }
            }

            // Handle row7 values
            if (!empty($row7[$index])) {
                $subject = trim($row7[$index]);
                if (in_array(strtoupper($subject), $this->nonSubjectColumns)) {
                    $headers[$index] = strtolower($subject);
                    continue;
                }

                // Keep MULOK type for all subjects after MULOK header until next header type
                if ($currentGroup === 'MULOK' && $index >= $mulokStartIndex) {
                    $headers[$index] = ['type' => 'MULOK', 'name' => $subject];
                    Log::info("Found MULOK subject", ['index' => $index, 'subject' => $subject]);
                } else if ($currentGroup === 'PAI') {
                    $headers[$index] = ['type' => 'PAI', 'name' => strtoupper($subject)];
                } else if ($currentGroup === null) {
                    $headers[$index] = ['type' => 'REGULAR', 'name' => strtoupper($subject)];
                }
            }
        }

        $this->headers = array_filter($headers);
        Log::info('Processed headers:', ['headers' => $this->headers]);
    }

    public function collection(Collection $rows)
    {
        $this->processHeaders($rows);

        Log::info('Starting ' . $this->category . ' import with ' . count($rows) . ' rows');

        // Skip 2 baris header (row 6 & 7)
        $dataRows = $rows->slice(2);

        foreach ($dataRows as $index => $row) {
            try {
                $processedRow = [];

                // Sesuaikan dengan posisi kolom di Excel
                $processedRow['no'] = $row[0]; // Kolom A
                $processedRow['nis'] = $row[2]; // Kolom C
                $processedRow['nama'] = $row[3]; // Kolom D

                // Proses nilai mata pelajaran
                foreach ($this->headers as $index => $header) {
                    if (!isset($row[$index]) || empty($row[$index])) {
                        continue;
                    }

                    if (is_array($header)) {
                        // For subject headers (PAI, MULOK, REGULAR)
                        $key = $header['type'] . '_' . $header['name'];
                        $processedRow[$key] = $row[$index];
                    } else if (!in_array(strtolower($header), $this->nonSubjectColumns)) {
                        // For any other non-system columns
                        $processedRow[$header] = $row[$index];
                    }
                }

                // Validasi data minimal
                if (!empty($processedRow['nis']) && !empty($processedRow['nama'])) {
                    $this->processRow($processedRow);
                    Log::info('Processed student:', [
                        'nis' => $processedRow['nis'],
                        'nama' => $processedRow['nama']
                    ]);
                } else {
                    Log::warning('Skipping row: Missing required fields', ['row' => $processedRow]);
                }

            } catch (\Exception $e) {
                Log::error('Error processing row: ' . $e->getMessage(), ['row' => $row]);
            }
        }
    }

    protected function processRow(array $row)
    {
        try {
            // Ini akan mencari siswa berdasarkan NIS, jika ada update nama, jika tidak ada create baru
            $student = Student::updateOrCreate(
                ['student_no' => $row['nis']], // Kondisi pencarian
                ['name' => $row['nama']]       // Data yang akan diupdate/create
            );

            // Get or create report card
            $reportCard = ReportCard::firstOrCreate([
                'student_id' => $student->id,
                'semester_id' => $this->semester_id,
                'class_id' => $this->class_id
            ]);

            foreach ($row as $key => $value) {
                if (in_array(strtolower($key), $this->nonSubjectColumns)) {
                    continue;
                }

                if (!empty($value) && is_numeric($value) && $value >= 0 && $value <= 100) {
                    // Extract subject name from the combined key
                    $parts = explode('_', $key, 2);
                    $subjectName = count($parts) > 1 ? $key : $parts[0];

                    $subject = Subject::firstOrCreate(['name' => $subjectName]);
                    $subject->addCategory($this->category);

                    ReportDetail::updateOrCreate(
                        [
                            'report_card_id' => $reportCard->id,
                            'subject_id' => $subject->id,
                        ],
                        [
                            $this->scoreColumn => $value
                        ]
                    );

                    Log::info("Saved {$this->category} score", [
                        'student' => $row['nis'],
                        'subject' => $subjectName,
                        'value' => $value
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error processing row for student {$row['nis']}: " . $e->getMessage());
            throw $e;
        }
    }
}
