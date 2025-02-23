<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Models\Subject;

class KeterampilanSheetImport extends PengetahuanSheetImport
{
    protected $category = 'Keterampilan';
    protected $scoreColumn = 'score_skill';

    protected function processHeaders(Collection $rows)
    {
        parent::processHeaders($rows);
        Log::info("Processing Keterampilan headers", ['category' => $this->category]);
    }

    // Remove overridden processRow since we're now handling categories in parent class
}
