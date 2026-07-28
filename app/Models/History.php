<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class History extends Model
{
    protected $fillable = [
        'user_id',
        'patient_name',
        'disease_id',
        'confidence_value',
        'symptoms',
        'diagnoses_rank',
    ];

    protected $casts = [
        'diagnoses_rank' => 'array',
    ];

    public function disease(): BelongsTo
    {
        return $this->belongsTo(Disease::class, 'disease_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
