<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_card_id',
        'subject_id',
        'score_knowledge',
        'score_skill'
    ];

    /**
     * Relasi ke raport (report_card).
     */
    public function reportCard()
    {
        return $this->belongsTo(ReportCard::class, 'report_card_id');
    }

    /**
     * Relasi ke mata pelajaran (subject).
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
