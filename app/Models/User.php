<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Properti kolom yang diizinkan untuk diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',      // Diubah dari 'name' menjadi 'nama' sesuai database
        'username',  // Menambahkan username
        'password',
        'role_id',   // Menambahkan role_id
    ];

    /**
     * Properti yang harus disembunyikan untuk serialisasi data.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Format mutasi tipe data bawaan.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
