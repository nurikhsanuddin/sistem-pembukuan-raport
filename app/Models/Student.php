<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['student_no', 'name', 'nisn'];
    protected $appends = ['current_class'];

    /**
     * Relasi ke kelas.
     */

    /**
     * Relasi ke raport.
     */
    public function reportCards()
    {
        return $this->hasMany(ReportCard::class);
    }

    public function getCurrentClassAttribute()
    {
        $latestReport = $this->reportCards()->latest()->first();
        return $latestReport ? $latestReport->schoolClass : null;
    }
}
