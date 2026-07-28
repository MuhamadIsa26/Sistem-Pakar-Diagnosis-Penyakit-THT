<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rule extends Model
{
    /**
     * Kolom database yang diizinkan untuk pengisian massal (Mass Assignment)
     * Kolom cf_pakar wajib ada di sini agar tidak dibuang oleh Laravel saat import.
     */
    protected $fillable = [
        'disease_id',
        'symptom_id',
        'cf_pakar',
    ];

    /**
     * Relasi Kebalikan menuju Model Disease (Penyakit)
     */
    public function disease(): BelongsTo
    {
        return $this->belongsTo(Disease::class, 'disease_id');
    }

    /**
     * Relasi Kebalikan menuju Model Symptom (Gejala)
     */
    public function symptom(): BelongsTo
    {
        return $this->belongsTo(Symptom::class, 'symptom_id');
    }
}
