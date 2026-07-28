<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\SymptomController;
use App\Models\Disease;
use App\Models\History;
use App\Models\Rule;
use App\Models\Symptom;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. Portal Publik / Landing Page Sebelum Login
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('index');
})->name('home');

/*
|--------------------------------------------------------------------------
| 2. Gerbang Otentikasi Pengguna (Guest Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Jalur Masuk (Login)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Jalur Pendaftaran (Register Pasien Baru)
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Jalur Pemulihan Kredensial (Lupa Password)
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'processForgotPassword'])->name('password.update');
});

// Jalur Keluar Sesi Akun (Diproteksi Auth)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| 3. Portal Administrasi Sistem Pakar (Auth & Admin Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Ringkasan Dashboard & Statistik Master Data
    Route::get('/dashboard', function () {
        $diseases = Disease::orderBy('code', 'asc')->get();
        $symptoms = Symptom::orderBy('code', 'asc')->get();

        $rules_count = Rule::count();
        $total_histories = History::count();
        $recent_histories = History::with('disease')->latest()->take(5)->get();

        return view('admin.dashboard_overview', compact(
            'diseases',
            'symptoms',
            'rules_count',
            'total_histories',
            'recent_histories'
        ));
    })->name('admin.dashboard');

    // CRUD Operasional Master Data Gejala Klinis
    Route::resource('symptoms', SymptomController::class)->names([
        'index' => 'admin.symptoms.index',
        'create' => 'admin.symptoms.create',
        'store' => 'admin.symptoms.store',
        'edit' => 'admin.symptoms.edit',
        'update' => 'admin.symptoms.update',
        'destroy' => 'admin.symptoms.destroy',
    ]);

    // CRUD Operasional Master Data Jenis Penyakit Medis
    Route::resource('diseases', DiseaseController::class)->names([
        'index' => 'admin.diseases.index',
        'create' => 'admin.diseases.create',
        'store' => 'admin.diseases.store',
        'edit' => 'admin.diseases.edit',
        'update' => 'admin.diseases.update',
        'destroy' => 'admin.diseases.destroy',
    ]);

    // Sinkronisasi Relasi Basis Pengetahuan (Rules Inferensi Pakar)
    Route::resource('rules', RuleController::class)->names([
        'index' => 'admin.rules.index',
        'create' => 'admin.rules.create',
        'store' => 'admin.rules.store',
        'destroy' => 'admin.rules.destroy',
    ])->except(['show', 'edit', 'update']);

    // Manajemen Berkas Riwayat Diagnosis Konsultasi Global
    Route::get('/history', [HistoryController::class, 'index'])->name('admin.history.index');
    Route::delete('/history/{history}', [HistoryController::class, 'destroy'])->name('admin.history.destroy');

    // Jalur Eksekusi Mass Import Berkas CSV/Excel
    Route::post('/diseases/import', [DiseaseController::class, 'import'])->name('admin.diseases.import');
    Route::post('/symptoms/import', [SymptomController::class, 'import'])->name('admin.symptoms.import');
    Route::post('/rules/import', [RuleController::class, 'import'])->name('admin.rules.import');
});

/*
|--------------------------------------------------------------------------
| 4. Portal Interaktif Layanan Pasien (Auth Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Halaman Utama Pasien (Dashboard Gabungan Home & About Privat)
    Route::get('/home', function () {
        return view('patient.dashboard');
    })->name('patient.home');

    // Rekam Jejak Log Riwayat Medis Pribadi Pasien
    Route::get('/my-history', function () {
        $histories = History::with('disease')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('patient.my_diagnosis_history', compact('histories'));
    })->name('patient.history');

    // Alur Pemeriksaan Keluhan Kuesioner Diagnosis Certainty Factor
    Route::get('/diagnosis/questionnaire', [HistoryController::class, 'showQuestionnaire'])->name('patient.diagnosis.questionnaire');
    Route::post('/diagnosis/process', [HistoryController::class, 'processDiagnosis'])->name('patient.diagnosis.process');

    // Tampilan Output Transkrip Hasil Evaluasi Diagnosis Medis Final
    Route::get('/diagnosis/result/{id}', [HistoryController::class, 'showResult'])->name('patient.diagnosis.result');
});
