@extends('layouts.app')

@section('title', 'Diagnosis History Log')

@section('content')
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold tracking-tight text-[#00685f]">Diagnosis History Log</h2>
            <p class="text-base text-[#3d4947] mt-1">Rekam medis berkas pelacakan hasil diagnosis pasien dan kalkulasi sistem
                inferensi.</p>
        </div>
    </div>

    <!-- Notifikasi Alert Sukses -->
    @if (session('success'))
        <div
            class="bg-green-50 border border-green-200 text-[#00685f] px-4 py-3 rounded-lg mb-6 text-sm flex items-center gap-2 font-medium">
            <span class="material-symbols-outlined text-lg">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <!-- Wadah Utama Tabel Log Riwayat -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-[0px_2px_4px_rgba(13,148,136,0.05)] overflow-hidden">
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-xs font-bold text-[#3d4947] tracking-wider uppercase">REKAM MEDIS PASIEN</h3>
            <div class="flex items-center gap-2">
                <button class="p-1 hover:bg-slate-200 text-[#3d4947] rounded transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-xl">filter_list</span>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead
                    class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-[#5a5f62] uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 w-16 text-center">No</th>
                        <th class="px-6 py-4 w-48">Nama Pasien</th>
                        <th class="px-6 py-4 w-56">Hasil Diagnosis</th>
                        <th class="px-6 py-4">Gejala yang Dialami</th>
                        <th class="px-6 py-4 w-44 text-center">Waktu Konsultasi</th>
                        <th class="px-6 py-4 w-28 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-[#171d1c]">
                    @forelse($histories ?? [] as $index => $history)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-center text-[#5a5f62] font-semibold">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-semibold text-[#171d1c]">{{ $history->patient_name }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span
                                        class="font-bold text-[#924628]">{{ $history->disease?->name ?? 'Tidak Terdeteksi' }}</span>
                                    <span
                                        class="text-[11px] font-mono text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded w-fit">
                                        Akurasi: {{ $history->confidence_value ?? '0' }}%
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1.5 max-w-md">
                                    @foreach ($history->symptoms ?? [] as $symptom)
                                        <span
                                            class="inline-flex items-center text-[11px] font-medium bg-[#eaefed] text-[#3d4947] px-2 py-0.5 rounded border border-[#bcc9c6]/30">
                                            {{ $symptom->code }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center text-[#5a5f62] text-xs">
                                {{ $history->created_at ? $history->created_at->format('d M Y, H:i') : '-' }} WIB
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('admin.history.destroy', $history->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus berkas riwayat medis ini?')" class="inline m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-700 font-semibold text-xs flex items-center gap-1 justify-center mx-auto cursor-pointer transition-colors">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <span
                                    class="material-symbols-outlined text-4xl block mb-2 text-slate-300">history_toggle_off</span>
                                Belum ada rekam riwayat diagnosis pasien yang tersimpan di dalam database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
