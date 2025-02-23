<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExcelUpload extends Model
{
    use HasFactory;

    protected $table = 'excel_uploads';

    protected $fillable = [
        'file_name',
        'uploaded_at',
        'class_id',
        'semester_id',
        'status'
    ];

    /**
     * Relasi ke kelas.
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Relasi ke semester.
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}
