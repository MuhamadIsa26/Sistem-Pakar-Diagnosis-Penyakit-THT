@extends('layouts.app')

@section('title', 'Symptom Management')

@section('content')
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between sm:items-end gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold tracking-tight text-[#00685f] mb-1">Symptom Management</h2>
            <p class="text-base text-[#3d4947]">Konfigurasi dan kelola daftar gejala klinis untuk mesin diagnosis THT-Pedia.
            </p>
        </div>
        <button type="button"
            class="trigger-add-symptom-modal inline-flex items-center gap-1.5 bg-[#00685f] text-white px-5 py-2.5 rounded-lg font-semibold text-sm shadow-md hover:bg-[#008378] transition-all active:scale-95 cursor-pointer">
            <span class="material-symbols-outlined text-xl">add</span>
            <span>Add New Symptom</span>
        </button>
    </div>

    <!-- Notifikasi Alert Sukses -->
    @if (session('success'))
        <div
            class="bg-green-50 border border-green-200 text-[#00685f] px-4 py-3 rounded-lg mb-6 text-sm flex items-center gap-2 font-medium">
            <span class="material-symbols-outlined text-lg">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <!-- Dashboard Stats Bento Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div
            class="bg-[#f0f5f2] p-6 rounded-xl border border-[#bcc9c6] shadow-sm flex flex-col justify-between min-h-[110px]">
            <p class="text-sm font-semibold text-[#3d4947]">Total Symptoms</p>
            <div class="flex items-baseline gap-1 mt-2">
                <span class="text-5xl font-bold text-[#00685f]">{{ $symptoms->count() }}</span>
                <span class="text-xs font-semibold text-[#3d4947]">Entries</span>
            </div>
        </div>

        <div
            class="bg-[#f0f5f2] p-6 rounded-xl border border-[#bcc9c6] shadow-sm flex flex-col justify-between min-h-[110px]">
            <div class="flex justify-between items-start mb-2">
                <p class="text-sm font-semibold text-[#3d4947]">Category: Ear</p>
                <span class="material-symbols-outlined text-[#924628]">hearing</span>
            </div>
            <div>
                <div class="w-full bg-[#bcc9c6] h-1.5 rounded-full overflow-hidden">
                    <div class="bg-[#924628] h-full w-[35%]"></div>
                </div>
                <p class="text-xs text-[#3d4947] mt-1.5 font-medium">8 Symptoms</p>
            </div>
        </div>

        <div
            class="bg-[#f0f5f2] p-6 rounded-xl border border-[#bcc9c6] shadow-sm flex flex-col justify-between min-h-[110px]">
            <div class="flex justify-between items-start mb-2">
                <p class="text-sm font-semibold text-[#3d4947]">Category: Nose</p>
                <span class="material-symbols-outlined text-[#00685f]">air</span>
            </div>
            <div>
                <div class="w-full bg-[#bcc9c6] h-1.5 rounded-full overflow-hidden">
                    <div class="bg-[#00685f] h-full w-[45%]"></div>
                </div>
                <p class="text-xs text-[#3d4947] mt-1.5 font-medium">11 Symptoms</p>
            </div>
        </div>

        <div
            class="bg-[#f0f5f2] p-6 rounded-xl border border-[#bcc9c6] shadow-sm flex flex-col justify-between min-h-[110px]">
            <div class="flex justify-between items-start mb-2">
                <p class="text-sm font-semibold text-[#3d4947]">Category: Throat</p>
                <span class="material-symbols-outlined text-[#5a5f62]">ecg_heart</span>
            </div>
            <div>
                <div class="w-full bg-[#bcc9c6] h-1.5 rounded-full overflow-hidden">
                    <div class="bg-[#5a5f62] h-full w-[20%]"></div>
                </div>
                <p class="text-xs text-[#3d4947] mt-1.5 font-medium">5 Symptoms</p>
            </div>
        </div>
    </div>

    <!-- MASS IMPORT SECTION COMPONENT -->
    <div class="mb-6 p-5 bg-slate-50 border border-slate-200 rounded-xl">
        <h3 class="text-xs font-bold text-[#3d4947] uppercase tracking-wider mb-2 flex items-center gap-1.5">
            <span class="material-symbols-outlined text-sm text-[#00685f]">upload_file</span>
            Mass Import Gejala via CSV
        </h3>
        <form action="{{ route('admin.symptoms.import') }}" method="POST" enctype="multipart/form-data"
            class="flex items-center gap-3">
            @csrf
            <input type="file" name="file" accept=".csv" required
                class="text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#00685f]/10 file:text-[#00685f] hover:file:bg-[#00685f]/20 cursor-pointer" />
            <button type="submit"
                class="bg-[#00685f] text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-[#008378] transition-colors flex items-center gap-1 cursor-pointer">
                <span class="material-symbols-outlined text-xs">tune</span> Proses Upload
            </button>
        </form>
        <p class="text-[10px] text-slate-400 mt-1.5">* Format Susunan Kolom CSV: **code, name**</p>
    </div>

    <!-- Main Data Table Container -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-[0px_2px_4px_rgba(13,148,136,0.05)] overflow-hidden">
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-xs font-bold text-[#3d4947] tracking-wider uppercase">SYMPTOM MASTER LIST</h3>
            <div class="flex items-center gap-2">
                <button class="p-1 hover:bg-slate-200 text-[#3d4947] rounded transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-xl">filter_list</span>
                </button>
                <button class="p-1 hover:bg-slate-200 text-[#3d4947] rounded transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-xl">download</span>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-[#5a5f62] uppercase tracking-wider">
                        <th class="px-6 py-3.5 w-32">Symptom ID</th>
                        <th class="px-6 py-3.5">Name</th>
                        <th class="px-6 py-3.5 w-44">Category</th>
                        <th class="px-6 py-3.5 w-40">Frequency</th>
                        <th class="px-6 py-3.5 w-32 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-[#171d1c]">
                    @forelse($symptoms as $symptom)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-3.5 font-mono font-bold text-[#00685f]">{{ $symptom->code }}</td>
                            <td class="px-6 py-3.5 font-medium text-[#171d1c]">{{ $symptom->name }}</td>
                            <td class="px-6 py-3.5">
                                @if (str_contains(strtolower($symptom->code), 'g1') || str_contains(strtolower($symptom->name), 'telinga'))
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#ffdbce] text-[#773215] text-xs font-semibold">
                                        <span class="material-symbols-outlined text-sm">hearing</span> Ear
                                    </span>
                                @elseif(str_contains(strtolower($symptom->code), 'g2') || str_contains(strtolower($symptom->name), 'hidung'))
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#89f5e7] text-[#005049] text-xs font-semibold">
                                        <span class="material-symbols-outlined text-sm">air</span> Nose
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#dce0e4] text-[#5e6367] text-xs font-semibold">
                                        <span class="material-symbols-outlined text-sm">ecg_heart</span> Throat
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 text-[#3d4947] font-medium border-none">
                                {{ $symptom->frequency ?? 'High (75%)' }}
                            </td>
                            <td class="px-6 py-3.5 text-right">
                                <div
                                    class="flex justify-end gap-3 opacity-100 group-hover:opacity-100 transition-opacity duration-200">
                                    <a href="{{ route('admin.symptoms.edit', $symptom->id) }}"
                                        class="text-[#00685f] hover:text-[#008378] transition-colors" title="Edit Gejala">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </a>
                                    <form action="{{ route('admin.symptoms.destroy', $symptom->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus gejala {{ $symptom->code }} dari sistem?')"
                                        class="inline m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-700 transition-colors cursor-pointer p-0 border-none bg-transparent"
                                            title="Delete Gejala">
                                            <span class="material-symbols-outlined text-lg">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <span
                                    class="material-symbols-outlined text-4xl block mb-2 text-slate-300">layers_clear</span>
                                Belum ada entri data gejala terdaftar di database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-100 flex justify-between items-center bg-slate-50/50">
            <p class="text-xs font-semibold text-[#3d4947]">Showing {{ $symptoms->count() }} symptoms</p>
            <div class="flex gap-1.5">
                <button
                    class="px-3 py-1 border border-[#bcc9c6] rounded-lg text-[#3d4947] hover:bg-[#eaefed] transition-colors disabled:opacity-50 text-xs font-bold flex items-center"
                    disabled>
                    <span class="material-symbols-outlined text-base">chevron_left</span>
                </button>
                <button
                    class="px-3 py-1 border border-[#bcc9c6] rounded-lg text-[#3d4947] hover:bg-[#eaefed] transition-colors text-xs font-bold flex items-center">
                    <span class="material-symbols-outlined text-base">chevron_right</span>
                </button>
            </div>
        </div>
    </div>

    <div class="mt-6 p-6 bg-[#eaefed] rounded-xl border border-dashed border-[#bcc9c6] flex gap-4 items-center">
        <div class="w-12 h-12 bg-[#008378] rounded-full flex items-center justify-center text-[#f4fffc] shrink-0">
            <span class="material-symbols-outlined text-xl">lightbulb</span>
        </div>
        <div>
            <h4 class="text-sm font-bold text-[#00685f]">Symptom Classification Note</h4>
            <p class="text-xs text-[#3d4947] mt-0.5 leading-relaxed">
                Menambahkan gejala baru secara otomatis akan memengaruhi kalkulasi pembobotan pada basis aturan relasi
                penyakit di Knowledge Base. Pastikan keakuratan klinis saat memetakan entri ke dalam kategori THT.
            </p>
        </div>
    </div>

    <div class="fixed bottom-0 right-0 p-6 opacity-5 pointer-events-none">
        <span class="material-symbols-outlined text-[120px] text-[#00685f]">medical_information</span>
    </div>

    @include('admin.symptom_add')
@endsection
