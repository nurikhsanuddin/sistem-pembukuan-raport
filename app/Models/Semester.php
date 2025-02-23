<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = ['number', 'description'];

    /**
     * Relasi ke raport.
     */
    public function reportCards()
    {
        return $this->hasMany(ReportCard::class, 'semester_id');
    }

    /**
     * Relasi ke upload file Excel (opsional).
     */
    public function excelUploads()
    {
        return $this->hasMany(ExcelUpload::class, 'semester_id');
    }
}
