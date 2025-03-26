<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportPdf extends Model
{
    protected $fillable = [
        'title',
        'file_path',
        'file_name',
        'file_size',
        'description',
        'user_id',
    ];

    /**
     * Get the user that uploaded this PDF.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
