<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    // Daftarkan kolom database yang diizinkan untuk diisi secara massal
    protected $fillable = [
        'code',
        'name',
        'description',
        'solution',
    ];
}
