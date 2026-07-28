<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Menampilkan Formulir Login Terpadu
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Memproses Data Login Pengguna
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role_id == 1) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('patient.history');
        }

        return back()->with('error', 'Username atau kata sandi yang Anda masukkan salah.')->onlyInput('username');
    }

    /**
     * Menampilkan Formulir Pendaftaran Akun (Registrasi)
     */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Memproses Pendaftaran Akun Baru Pasien
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'nama' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => 2,
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran akun berhasil! Silakan masuk menggunakan username Anda.');
    }

    /**
     * TAMBAHKAN INI: Menampilkan Halaman Lupa Password
     */
    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * TAMBAHKAN INI: Memproses Reset Kata Sandi Baru Pasien
     */
    public function processForgotPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'exists:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'username.exists' => 'Username tidak ditemukan di dalam sistem rekam medis.',
        ]);

        // Mengambil data user berdasarkan username terdaftar
        $user = User::where('username', $request->username)->first();

        // Memperbarui password dengan hashing baru
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Kata sandi akun Anda berhasil diperbarui! Silakan masuk kembali.');
    }

    /**
     * Memproses Keluar Sistem (Logout)
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
