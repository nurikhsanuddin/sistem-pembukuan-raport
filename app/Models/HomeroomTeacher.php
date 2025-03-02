<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeroomTeacher extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'nip', 'phone', 'email', 'class_id'];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function assignedClass()
    {
        // Kelas yang ditugaskan (berdasarkan homeroom_teacher_id di tabel classes)
        return $this->hasOne(SchoolClass::class, 'homeroom_teacher_id');
    }
}
