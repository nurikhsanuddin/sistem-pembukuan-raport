<?php

namespace App\Imports;

interface WithCustomHeaderRow
{
    public function prepareForValidation($rows, $row): array;
}
