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

        foreach ($row6 as $index => $value) {
            if (!empty($value)) {
                if ($value === 'PAI') {
                    $currentGroup = 'PAI';
                    $subject = strtoupper(trim($row7[$index]));
                    if (in_array($subject, $this->paiSubjects)) {
                        $headers[$index] = $subject;
                    }
                } else if (strtoupper(trim($value)) === 'MULOK') {
                    $currentGroup = 'MULOK';
                    $subject = trim($row7[$index]);
                    $headers[$index] = ['type' => 'MULOK', 'name' => $subject];
                    Log::info("Found MULOK subject", ['index' => $index, 'subject' => $subject]);
                } else {
                    $currentGroup = null;
                    $headers[$index] = $value;
                }
            } else if (!empty($row7[$index])) {
                $subject = trim($row7[$index]);
                if ($currentGroup === 'MULOK') {
                    $headers[$index] = ['type' => 'MULOK', 'name' => $subject];
                    Log::info("Found MULOK subject in row7", ['index' => $index, 'subject' => $subject]);
                } else {
                    $headers[$index] = strtoupper($subject);
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
                    if (
                        isset($row[$index]) && !empty($row[$index]) &&
                        !in_array($header, ['no', 'nis', 'nama', 'jk', 'jumlah'])
                    ) {
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
                if (in_array(strtolower($key), ['no', 'nis', 'nisn', 'nama', 'jk', 'jumlah'])) {
                    continue;
                }

                if (!empty($value) && is_numeric($value) && $value >= 0 && $value <= 100) {
                    // Check if the header is an array (MULOK subject)
                    if (is_array($key) && isset($key['type']) && $key['type'] === 'MULOK') {
                        $subjectName = 'MULOK_' . $key['name'];
                        Log::info("Processing MULOK subject", ['subject' => $subjectName, 'value' => $value]);
                    } else if (in_array($key, $this->paiSubjects)) {
                        $subjectName = 'PAI_' . $key;
                    } else {
                        $subjectName = $key;
                    }

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
