@extends('layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold tracking-tight text-[#00685f]">Dashboard Overview</h2>
        <p class="text-base text-[#3d4947] mt-1">Sistem performa mesin inferensi dan manajemen basis aturan diagnosis.</p>
    </div>

    <!-- Stats Bento Grid yang Sinkron dengan Database -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Gejala Card -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-3">
                <div class="p-2 bg-[#00685f]/10 rounded-lg text-[#00685f]">
                    <span class="material-symbols-outlined">medical_services</span>
                </div>
            </div>
            <p class="text-sm font-semibold text-[#3d4947]">Total Gejala</p>
            <h3 class="text-5xl font-bold text-[#00685f] mt-1">{{ $symptoms->count() }}</h3>
        </div>

        <!-- Total Penyakit Card -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-3">
                <div class="p-2 bg-[#924628]/10 rounded-lg text-[#924628]">
                    <span class="material-symbols-outlined">folder_special</span>
                </div>
            </div>
            <p class="text-sm font-semibold text-[#3d4947]">Total Penyakit</p>
            <h3 class="text-5xl font-bold text-[#924628] mt-1">{{ $diseases->count() }}</h3>
        </div>

        <!-- Basis Pengetahuan / Rules Card -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-3">
                <div class="p-2 bg-[#5a5f62]/10 rounded-lg text-[#5a5f62]">
                    <span class="material-symbols-outlined">rule</span>
                </div>
                <span class="text-[#5a5f62] text-xs font-semibold">Aktif</span>
            </div>
            <p class="text-sm font-semibold text-[#3d4947]">Basis Pengetahuan</p>
            <h3 class="text-5xl font-bold text-[#5a5f62] mt-1">{{ $rules_count ?? 0 }}</h3>
        </div>

        <!-- Akurasi Sistem Card -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-3">
                <div class="p-2 bg-[#00685f]/10 rounded-lg text-[#00685f]">
                    <span class="material-symbols-outlined">analytics</span>
                </div>
                <span class="text-[#00685f] text-xs font-semibold">Stabil</span>
            </div>
            <p class="text-sm font-semibold text-[#3d4947]">Total Riwayat Diagnosis</p>
            <h3 class="text-5xl font-bold text-[#00685f] mt-1">{{ $total_histories ?? 0 }}</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 flex flex-col gap-6">
            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                <h4 class="text-lg font-bold text-[#171d1c] mb-4">Aksi Cepat</h4>
                <div class="space-y-3">
                    <button type="button"
                        class="trigger-add-symptom-modal w-full flex items-center justify-between p-3.5 bg-[#00685f] text-white rounded-lg font-semibold text-sm hover:bg-[#00685f]/90 transition-colors text-left cursor-pointer">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined">add_circle</span>
                            Tambah Gejala Baru
                        </div>
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>

                    <button type="button"
                        class="trigger-add-rule-modal w-full flex items-center justify-between p-3.5 bg-white border border-[#00685f] text-[#00685f] rounded-lg font-semibold text-sm hover:bg-[#00685f]/5 transition-colors text-left cursor-pointer">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined">rule_folder</span>
                            Atur Aturan Baru
                        </div>
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
            </div>

            <div class="bg-[#008378] p-6 rounded-xl text-[#f4fffc] relative overflow-hidden shadow-sm">
                <div class="relative z-10">
                    <h4 class="text-lg font-bold mb-1">Kesehatan Mesin</h4>
                    <p class="text-xs opacity-90 mb-4">Mesin inferensi berjalan optimal tanpa konflik logika.</p>
                    <div class="flex items-center gap-3">
                        <div class="h-2 flex-1 bg-white/20 rounded-full overflow-hidden">
                            <div class="h-full bg-white w-[100%]"></div>
                        </div>
                        <span class="text-sm font-bold">100%</span>
                    </div>
                </div>
                <span
                    class="material-symbols-outlined absolute -bottom-4 -right-4 text-white/10 text-[120px] pointer-events-none">health_and_safety</span>
            </div>
        </div>

        <!-- Tabel Log Aktivitas Konsultasi Terbaru Pasien -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col h-full">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h4 class="text-lg font-bold text-[#171d1c]">Log Aktivitas Terbaru</h4>
                    <a href="{{ route('admin.history.index') }}"
                        class="text-[#00685f] text-sm font-semibold hover:underline cursor-pointer">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-3 text-xs font-bold text-[#3d4947] uppercase tracking-wider">Aktivitas
                                </th>
                                <th class="px-6 py-3 text-xs font-bold text-[#3d4947] uppercase tracking-wider">Pasien /
                                    Entitas</th>
                                <th class="px-6 py-3 text-xs font-bold text-[#3d4947] uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-3 text-xs font-bold text-[#3d4947] uppercase tracking-wider">Tingkat
                                    Keyakinan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-[#171d1c]">
                            @forelse($recent_histories ?? [] as $history)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="material-symbols-outlined text-[#00685f] text-base">analytics</span>
                                            <span class="font-medium">Diagnosis Selesai</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-[#3d4947]">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-slate-800">{{ $history->patient_name }}</span>
                                            <span
                                                class="text-xs text-[#924628] font-medium">{{ $history->disease?->name ?? 'Tidak Terdeteksi' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-[#3d4947] text-xs">
                                        {{ $history->created_at ? $history->created_at->diffForHumans() : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-0.5 bg-[#00685f]/10 text-[#00685f] text-[10px] font-bold rounded-md uppercase">
                                            {{ $history->confidence_value }}% Certeinty
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                        Belum ada aktivitas rekam diagnosis pasien terbaru saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- PERBAIKAN UTAMA: Menyertakan kedua modal partial secara lengkap di paling bawah dasbor -->
    @include('admin.rule_add')
    @include('admin.symptom_add')
@endsection
