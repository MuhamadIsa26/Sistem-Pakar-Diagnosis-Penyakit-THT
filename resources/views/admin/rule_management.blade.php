@extends('layouts.app')

@section('title', 'Knowledge Base Management')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold tracking-tight text-[#00685f]">Knowledge Base Management</h2>
            <p class="text-base text-[#3d4947] mt-1">Kelola aturan kombinasi gejala yang merujuk pada kesimpulan penyakit.
            </p>
        </div>
        <button type="button"
            class="trigger-add-rule-modal inline-flex items-center gap-2 bg-[#5a5f62] text-white font-semibold px-4 py-2.5 rounded-lg text-sm shadow-sm hover:bg-[#5a5f62]/90 transition-all active:scale-95 cursor-pointer">
            <span class="material-symbols-outlined text-sm">add_circle</span>
            <span>Buat Aturan Baru</span>
        </button>
    </div>

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
            <span class="material-symbols-outlined text-sm text-[#5a5f62]">upload_file</span>
            Mass Import Matriks Aturan (Rules) via CSV
        </h3>
        <form action="{{ route('admin.rules.import') }}" method="POST" enctype="multipart/form-data"
            class="flex items-center gap-3">
            @csrf
            <input type="file" name="file" accept=".csv" required
                class="text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300 cursor-pointer" />
            <button type="submit"
                class="bg-[#5a5f62] text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-[#5a5f62]/90 transition-colors flex items-center gap-1 cursor-pointer">
                <span class="material-symbols-outlined text-xs">tune</span> Proses Upload
            </button>
        </form>
        <p class="text-[10px] text-slate-400 mt-1.5">* Format Susunan Kolom CSV: **disease_code, symptom_code, cf_pakar**
            (Contoh: P001, G001, 0.8)</p>
    </div>

    <div class="space-y-6">
        @forelse($rules as $diseaseId => $diseaseRules)
            @php $disease = $diseaseRules->first()->disease; @endphp
            <div
                class="bg-white rounded-xl border border-slate-200 shadow-[0px_2px_4px_rgba(13,148,136,0.05)] overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <div>
                        <span
                            class="text-xs font-bold px-2 py-0.5 bg-[#924628]/10 text-[#924628] rounded font-mono">{{ $disease->code }}</span>
                        <h3 class="text-base font-bold text-[#171d1c] inline-block ml-2">{{ $disease->name }}</h3>
                    </div>
                    <span class="text-xs text-[#3d4947] font-medium">{{ $diseaseRules->count() }} Gejala Terikat</span>
                </div>

                <ul class="divide-y divide-slate-100 text-sm text-[#171d1c]">
                    @foreach ($diseaseRules as $rule)
                        <li class="px-6 py-3.5 flex justify-between items-center hover:bg-slate-50/30 transition-colors">
                            <div class="flex items-center gap-3">
                                <span
                                    class="font-mono text-xs font-bold text-[#00685f] bg-[#00685f]/5 px-2 py-0.5 rounded">{{ $rule->symptom->code }}</span>
                                <span class="text-[#3d4947] font-medium">{{ $rule->symptom->name }}</span>
                                <span
                                    class="text-xs font-bold text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded font-mono">CF:
                                    {{ $rule->cf_pakar }}</span>
                            </div>
                            <form action="{{ route('admin.rules.destroy', $rule->id) }}" method="POST"
                                onsubmit="return confirm('Hapus gejala ini dari indikasi penyakit {{ $disease->name }}?')"
                                class="inline m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-xs text-red-600 hover:text-red-700 font-bold flex items-center gap-1 cursor-pointer border-none bg-transparent">
                                    <span class="material-symbols-outlined text-sm">playlist_remove</span>
                                    Lepas Aturan
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        @empty
            <div class="bg-white p-12 text-center text-slate-400 rounded-xl border border-slate-200 shadow-sm">
                <span class="material-symbols-outlined text-4xl block mb-2 text-slate-300">rule</span>
                Belum ada basis pengetahuan aturan yang didefinisikan.
            </div>
        @endforelse
    </div>

    @include('admin.rule_add')
@endsection
