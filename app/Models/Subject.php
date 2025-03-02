<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'categories',
        'description',
        'pengetahuan_A',
        'pengetahuan_B',
        'pengetahuan_C',
        'pengetahuan_D',
        'keterampilan_A',
        'keterampilan_B',
        'keterampilan_C',
        'keterampilan_D',
    ];

    protected $casts = [
        'categories' => 'array'
    ];

    /**
     * Relasi ke detail raport.
     */
    public function reportDetails()
    {
        return $this->hasMany(ReportDetail::class, 'subject_id');
    }

    public function addCategory($category)
    {
        $categories = $this->categories ?? [];
        if (!in_array($category, $categories)) {
            $categories[] = $category;
            $this->categories = $categories;
            $this->save();
        }
    }
}
