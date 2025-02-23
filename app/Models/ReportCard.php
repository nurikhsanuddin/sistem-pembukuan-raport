<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportCard extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'semester_id', 'class_id', 'printed_at'];

    /**
     * Relasi ke siswa.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Relasi ke semester.
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    /**
     * Relasi ke detail raport.
     */
    public function reportDetails()
    {
        return $this->hasMany(ReportDetail::class, 'report_card_id');
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }


}
