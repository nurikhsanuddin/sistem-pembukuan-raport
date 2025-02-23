<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = ['name', 'academic_year'];

    public function excelUploads()
    {
        return $this->hasMany(ExcelUpload::class, 'class_id');
    }

    public function reportCards()
    {
        return $this->hasMany(ReportCard::class, 'class_id');
    }


}
