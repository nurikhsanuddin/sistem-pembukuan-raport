<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportCardImport implements WithMultipleSheets
{
    protected $semester_id;
    protected $class_id;

    public function __construct($semester_id, $class_id)
    {
        $this->semester_id = $semester_id;
        $this->class_id = $class_id;
    }

    public function sheets(): array
    {
        return [
            'Pengetahuan' => new PengetahuanSheetImport($this->semester_id, $this->class_id),
            'Keterampilan' => new KeterampilanSheetImport($this->semester_id, $this->class_id),
        ];
    }
}
