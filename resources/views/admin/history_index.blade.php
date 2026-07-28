@extends('layouts.app')

@section('title', 'History Log')

@section('content')
    <div class="space-y-6">

        <!-- 1. NOTIFIKASI UMPAN BALIK BERHASIL -->
        @if (session('success'))
            <div
                class="p-4 bg-emerald-50 border border-[#bcc9c6] text-[#00685f] rounded-xl text-xs font-semibold flex items-center gap-2 shadow-2xs">
                <span class="material-symbols-outlined text-base font-bold">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <!-- 2. JUDUL HALAMAN LOG KONTEN -->
        <div>
            <h1 class="text-2xl font-extrabold text-[#171d1c] tracking-tight">History Log</h1>
            <p class="text-xs text-[#3d4947] mt-1">Memantau seluruh jejak rekam medis diagnosis Certainty Factor yang
                dilakukan oleh pasien secara global.</p>
        </div>

        <!-- 3. KONTEN UTAMA: TABEL LOG RIWAYAT RESPONSIF -->
        <div class="bg-white border border-[#bcc9c6] rounded-2xl shadow-xs overflow-hidden">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left text-xs min-w-[700px]">
                    <thead class="bg-[#eaefed] text-[#171d1c] font-bold border-b border-[#bcc9c6]">
                        <tr>
                            <th class="p-4 w-12 text-center">No</th>
                            <th class="p-4">Nama Pasien</th>
                            <th class="p-4">Hasil Indikasi Utama</th>
                            <th class="p-4 text-center">Tingkat CF</th>
                            <th class="p-4">Waktu Pemeriksaan</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#dee4e1]">
                        @forelse($histories as $index => $history)
                            <tr class="hover:bg-[#f0f5f2]/40 transition-colors">
                                <!-- Nomor Urut -->
                                <td class="p-4 text-center font-medium text-[#3d4947] font-mono">
                                    {{ sprintf('%02d', $index + 1) }}
                                </td>

                                <!-- Nama Lengkap Pasien -->
                                <td class="p-4 font-bold text-[#171d1c] break-words max-w-[180px]">
                                    {{ $history->patient_name }}
                                </td>

                                <!-- Hasil Penyakit Tertinggi -->
                                <td class="p-4 font-semibold text-[#171d1c]">
                                    {{ $history->disease?->name ?? 'Tidak Terdeteksi Gejala' }}
                                    <span class="block font-mono text-[10px] text-[#3d4947] font-normal mt-0.5">
                                        Kode: {{ $history->disease?->code ?? '-' }}
                                    </span>
                                </td>

                                <!-- Nilai Kepastian Persentase Akurasi -->
                                <td class="p-4 text-center">
                                    <span
                                        class="px-2.5 py-1 text-[10px] font-black font-mono rounded-lg shadow-3xs inline-block
                                    {{ $history->confidence_value >= 70
                                        ? 'bg-[#f0f5f2] text-[#00685f] border border-[#bcc9c6]'
                                        : ($history->confidence_value >= 45
                                            ? 'bg-amber-50 text-amber-700 border border-amber-200'
                                            : 'bg-rose-50 text-rose-700 border border-rose-200') }}">
                                        {{ number_format($history->confidence_value, 2) }}%
                                    </span>
                                </td>

                                <!-- Tanggal dan Jam Sinkron Database -->
                                <td class="p-4 text-[#3d4947] font-medium">
                                    {{ $history->created_at->translatedFormat('d M Y • H:i') }} WIB
                                </td>

                                <!-- Tombol Hapus Log Tindakan -->
                                <td class="p-4 text-center">
                                    <form action="{{ route('admin.history.destroy', $history->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan rekam medis milik {{ $history->patient_name }} secara permanen?')"
                                        class="inline m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer inline-flex items-center justify-center"
                                            title="Hapus Catatan Riwayat">
                                            <span class="material-symbols-outlined text-base font-bold">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <!-- Tampilan Jika Tabel Masih Kosong -->
                            <tr>
                                <td colspan="6"
                                    class="p-12 text-center text-[#3d4947] font-medium italic bg-[#f5faf8]/30">
                                    <span
                                        class="material-symbols-outlined text-4xl opacity-30 block mb-2">folder_open</span>
                                    Belum terdapat catatan log riwayat konsultasi pasien yang terekam di database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
