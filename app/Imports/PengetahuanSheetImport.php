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
    protected $nonSubjectColumns = ['no', 'nis', 'nisn', 'nama', 'jk', 'jumlah'];

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
            $value = trim($value);
            if (!empty($value)) {
                //detecting value row 6 if is PAI or MULOK
                if ($value === 'PAI') {
                    $currentGroup = 'PAI';
                    $subject = strtoupper(trim($row7[$index]));
                    if (!empty($subject)) {
                        $headers[$index] = ['type' => 'PAI', 'name' => $subject];
                        Log::info("Found PAI subject", ['index' => $index, 'subject' => $subject]);
                    }
                    //detecting value row 6 if is MULOK
                } else if (strtoupper($value) === 'MULOK') {
                    $currentGroup = 'MULOK';
                    $subject = trim($row7[$index]);
                    if (!empty($subject)) {
                        $headers[$index] = ['type' => 'MULOK', 'name' => $subject];
                        Log::info("Found MULOK subject", ['index' => $index, 'subject' => $subject]);
                    }
                } else {
                    $currentGroup = null;
                    $headers[$index] = ['type' => 'REGULAR', 'name' => $value];
                }
            } else if (!empty($row7[$index])) {
                $subject = trim($row7[$index]);
                if ($currentGroup === 'MULOK') {
                    $headers[$index] = ['type' => 'MULOK', 'name' => $subject];
                    Log::info("Found MULOK subject in row7", ['index' => $index, 'subject' => $subject]);
                } else if ($currentGroup === 'PAI') {
                    $headers[$index] = ['type' => 'PAI', 'name' => strtoupper($subject)];
                    Log::info("Found PAI subject in row7", ['index' => $index, 'subject' => $subject]);
                } else {
                    // Handle special columns
                    if (in_array(strtolower($subject), $this->nonSubjectColumns)) {
                        $headers[$index] = strtolower($subject);
                    } else {
                        $headers[$index] = ['type' => 'REGULAR', 'name' => strtoupper($subject)];
                    }
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
                        !in_array(is_array($header) ? $header['name'] : $header, ['no', 'nis', 'nama', 'jk', 'jumlah'])
                    ) {
                        // Use a string key for the processedRow array
                        $key = is_array($header) ? json_encode($header) : $header;
                        $processedRow[$key] = $row[$index];
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
                if (!is_array($key) && in_array(strtolower($key), $this->nonSubjectColumns)) {
                    continue;
                }

                if (!empty($value) && is_numeric($value) && $value >= 0 && $value <= 100) {
                    $headerData = is_array($key) ? $key : json_decode($key, true);

                    if (is_array($headerData) && isset($headerData['type'], $headerData['name'])) {
                        switch ($headerData['type']) {
                            case 'PAI':
                                $subjectName = 'PAI_' . $headerData['name'];
                                break;
                            case 'MULOK':
                                $subjectName = 'MULOK_' . $headerData['name'];
                                break;
                            default:
                                $subjectName = $headerData['name'];
                        }

                        Log::info("Processing subject", [
                            'type' => $headerData['type'],
                            'name' => $subjectName,
                            'value' => $value
                        ]);

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
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("Error processing row for student {$row['nis']}: " . $e->getMessage());
            throw $e;
        }
    }
}
