<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Predikat extends Model
{
    use HasFactory;

    protected $fillable = ['predikat', 'nilai_min', 'nilai_max', 'deskripsi'];

    public function isInRange($nilai)
    {
        return $nilai >= $this->nilai_min && $nilai <= $this->nilai_max;
    }

    public static function getPredikatFromNilai($nilai)
    {
        return self::where('nilai_min', '<=', $nilai)
            ->where('nilai_max', '>=', $nilai)
            ->first();
    }
}
