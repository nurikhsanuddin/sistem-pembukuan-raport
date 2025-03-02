<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = ['name', 'academic_year', 'homeroom_teacher_id'];

    public function excelUploads()
    {
        return $this->hasMany(ExcelUpload::class, 'class_id');
    }

    public function reportCards()
    {
        return $this->hasMany(ReportCard::class, 'class_id');
    }

    public function students()
    {
        // Get students through report_cards table
        return $this->hasManyThrough(
            Student::class,
            ReportCard::class,
            'class_id', // Foreign key on report_cards table
            'id', // Foreign key on students table
            'id', // Local key on classes table
            'student_id' // Local key on report_cards table
        )->distinct(); // Add distinct to avoid duplicate students
    }

    // Pastikan ada relasi dengan HomeRoom Teacher
    public function homeroomTeacher()
    {
        return $this->belongsTo(HomeroomTeacher::class, 'homeroom_teacher_id');
    }
}
