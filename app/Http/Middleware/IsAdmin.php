<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Menangani permintaan masuk (Filter Keamanan Hak Akses Admin).
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pastikan pengguna sudah login terlebih dahulu
        // 2. Pastikan pengguna memiliki nilai role_id sama dengan 1 (Level Admin Pakar)
        if (! auth()->check() || auth()->user()->role_id != 1) {
            // Jika tidak memenuhi syarat admin, lemparkan error 403 Forbidden Access
            abort(403, 'Akses tidak sah. Halaman ini dilindungi dan hanya boleh diakses oleh Admin Pakar.');
        }

        return $next($request);
    }
}
