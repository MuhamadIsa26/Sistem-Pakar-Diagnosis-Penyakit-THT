@extends('layouts.app')

@section('title', 'Disease Management')

@section('content')
    <!-- Batas Atas Header Konten -->
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold tracking-tight text-[#00685f]">Disease Management</h2>
            <p class="text-base text-[#3d4947] mt-1">Kelola daftar jenis penyakit atau konklusi akhir hasil diagnosis sistem
                pakar.</p>
        </div>
        <button type="button"
            class="trigger-add-disease-modal inline-flex items-center gap-2 bg-[#924628] text-white font-semibold px-4 py-2.5 rounded-lg text-sm shadow-sm hover:bg-[#924628]/90 transition-colors cursor-pointer">
            <span class="material-symbols-outlined text-sm">add_circle</span>
            <span>Tambah Penyakit</span>
        </button>
    </div>

    <!-- Alert Notifikasi Flash Session -->
    @if (session('success'))
        <div
            class="bg-green-50 border border-green-200 text-[#00685f] px-4 py-3 rounded-lg mb-6 text-sm flex items-center gap-2 font-medium">
            <span class="material-symbols-outlined text-lg">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <!-- MASS IMPORT SECTION COMPONENT -->
    <div class="mb-6 p-5 bg-slate-50 border border-slate-200 rounded-xl">
        <h3 class="text-xs font-bold text-[#3d4947] uppercase tracking-wider mb-2 flex items-center gap-1.5">
            <span class="material-symbols-outlined text-sm text-[#924628]">upload_file</span>
            Mass Import Penyakit via CSV
        </h3>
        <form action="{{ route('admin.diseases.import') }}" method="POST" enctype="multipart/form-data"
            class="flex items-center gap-3">
            @csrf
            <input type="file" name="file" accept=".csv" required
                class="text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#924628]/10 file:text-[#924628] hover:file:bg-[#924628]/20 cursor-pointer" />
            <button type="submit"
                class="bg-[#924628] text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-[#924628]/90 transition-colors flex items-center gap-1 cursor-pointer">
                <span class="material-symbols-outlined text-xs">tune</span> Proses Upload
            </button>
        </form>
        <p class="text-[10px] text-slate-400 mt-1.5">* Format Susunan Kolom CSV: **code, name, description, solution**</p>
    </div>

    <!-- Wadah Tabel Data Master -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-[0px_2px_4px_rgba(13,148,136,0.05)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead
                    class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-[#3d4947] uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 w-32">Kode Penyakit</th>
                        <th class="px-6 py-4 w-64">Nama Medis</th>
                        <th class="px-6 py-4">Deskripsi / Penanganan Solusi</th>
                        <th class="px-6 py-4 w-44 text-center">Aksi Management</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-[#171d1c]">
                    @forelse($diseases as $disease)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-[#924628]">{{ $disease->code }}</td>
                            <td class="px-6 py-4 font-semibold text-[#171d1c]">{{ $disease->name }}</td>
                            <td class="px-6 py-4 text-[#3d4947] leading-relaxed">{{ $disease->description ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-4">
                                    <a href="{{ route('admin.diseases.edit', $disease->id) }}"
                                        class="inline-flex items-center gap-1 text-yellow-600 hover:text-yellow-700 font-semibold transition-colors">
                                        <span class="material-symbols-outlined text-base">edit</span>
                                        Ubah
                                    </a>
                                    <span class="text-slate-200">|</span>
                                    <form action="{{ route('admin.diseases.destroy', $disease->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penyakit ini?')"
                                        class="inline m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 text-red-600 hover:text-red-700 font-semibold transition-colors cursor-pointer">
                                            <span class="material-symbols-outlined text-base">delete</span>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                <span
                                    class="material-symbols-outlined text-4xl block mb-2 text-slate-300">layers_clear</span>
                                Belum ada data penyakit yang terdaftar di database sistem.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('admin.disease_add')
@endsection
