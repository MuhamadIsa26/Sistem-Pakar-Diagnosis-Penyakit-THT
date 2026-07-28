@extends('layouts.patient')

@section('title', 'Home & About')

@section('content')
    <div class="space-y-16">

        <!-- SECTION 1: HERO CONTAINER (HOME PART) -->
        <header id="home"
            class="relative overflow-hidden bg-white rounded-2xl border border-[#bcc9c6] p-6 sm:p-10 shadow-xs">
            <div class="relative z-10">
                <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-center">

                    <!-- Headline Sambutan Keluhan Pasien -->
                    <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-7 lg:text-left">
                        <span
                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-[#f0f5f2] text-[#00685f] text-[10px] font-bold uppercase tracking-wider mb-4 border border-[#bcc9c6]">
                            <span class="material-symbols-outlined text-xs">account_circle</span> Portal Resmi Pasien
                            Terotentikasi
                        </span>
                        <h1 class="text-3xl font-black tracking-tight text-slate-900 sm:text-4xl lg:text-4xl leading-tight">
                            Mulai Cek Kesehatan <span class="text-[#00685f]">Anda</span> Hari Ini.
                        </h1>
                        <p class="mt-4 text-xs text-[#3d4947] leading-relaxed font-medium">
                            Halo {{ auth()->user()->nama ?? auth()->user()->name }}, silakan gunakan portal khusus pasien
                            ini untuk berkonsultasi secara mandiri. Mesin sistem pakar Certainty Factor kami siap
                            mengevaluasi bobot gejala klinis Anda untuk memunculkan kesimpulan penyakit Telinga, Hidung,
                            atau Tenggorokan secara cepat dan akurat.
                        </p>

                        <div class="mt-6 sm:max-w-lg sm:mx-auto sm:text-center lg:text-left lg:mx-0">
                            <a href="{{ route('patient.diagnosis.questionnaire') }}"
                                class="inline-flex items-center gap-2 px-6 py-3.5 bg-[#00685f] hover:bg-[#008378] text-white text-xs font-bold rounded-xl transition-all shadow-md active:scale-95 cursor-pointer">
                                <span class="material-symbols-outlined text-sm">assignment_turned_in</span>
                                <span>Isi Kuesioner Gejala Sekarang</span>
                            </a>
                        </div>
                    </div>

                    <!-- Komponen Ilustrasi Kanan Mini Preview -->
                    <div
                        class="mt-10 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-5 lg:flex lg:justify-center">
                        <div
                            class="w-full bg-gradient-to-tr from-[#f0f5f2] to-white p-5 rounded-xl border border-slate-200 shadow-2xs relative">
                            <div class="absolute -top-4 -right-4 w-12 h-12 bg-[#924628]/10 rounded-full blur-xl"></div>

                            <div
                                class="bg-white p-4 rounded-xl border border-slate-100 shadow-3xs mb-3 flex items-center gap-3">
                                <span
                                    class="material-symbols-outlined p-2 bg-[#f0f5f2] text-[#00685f] rounded-lg">hearing</span>
                                <div class="text-left">
                                    <h4 class="text-xs font-bold text-slate-800">Otitis Media Akut (OMA)</h4>
                                    <p class="text-[10px] text-slate-400 font-medium">Derajat Kepastian Maksimal Pakar</p>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-3xs flex items-center gap-3">
                                <span
                                    class="material-symbols-outlined p-2 bg-[#ffdbce] text-[#924628] rounded-lg">air</span>
                                <div class="text-left">
                                    <h4 class="text-xs font-bold text-slate-800">Sinusitis &amp; Rhinitis</h4>
                                    <p class="text-[10px] text-slate-400 font-medium">Evaluasi Multi-Kombinasi Gejala</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- SECTION 2: ABOUT CONTAINER (ABOUT PART) -->
        <section id="about" class="bg-white rounded-2xl border border-[#bcc9c6] p-6 sm:p-10 shadow-xs">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <h2 class="text-xs font-bold tracking-widest text-[#00685f] uppercase">Metode Komputasi</h2>
                <p class="text-2xl font-extrabold tracking-tight text-slate-900 mt-2">Bagaimana Sistem Mendiagnosis?</p>
                <div class="w-12 h-1 bg-[#00685f] mx-auto mt-3 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="space-y-4">
                    <p class="text-xs font-semibold text-[#00685f] uppercase tracking-wider">Algoritma Certainty Factor</p>
                    <h3 class="text-lg font-bold text-slate-900 leading-snug">Mengukur Kepastian di Tengah Ketidakpastian
                        Klinis</h3>
                    <p class="text-xs text-[#3d4947] leading-relaxed">
                        Ketika Anda memilih tingkat keyakinan terhadap keluhan gejala pada kuesioner, sistem akan
                        mencocokkan pilihan Anda dengan matriks aturan Certainty Factor (CF) pakar asli yang tersimpan
                        di database. Rumus matematika CF kemudian mengakumulasikan nilai tersebut untuk menghasilkan
                        persentase final.
                    </p>
                    <p class="text-xs text-[#3d4947] leading-relaxed">
                        Hasil akhir rekam medis akan diurutkan secara otomatis dari bobot persentase tertinggi, memberikan
                        Anda informasi hipotesis penyakit paling logis beserta penanganan solusinya secara terstruktur.
                    </p>
                </div>

                <!-- Statistik Singkat Sistem Pakar -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl text-center">
                        <span class="material-symbols-outlined text-[#924628] text-2xl font-bold block mb-1">layers</span>
                        <span class="text-xl font-black text-slate-900 block font-mono">5</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase">Penyakit Utama</span>
                    </div>
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl text-center">
                        <span class="material-symbols-outlined text-[#00685f] text-2xl font-bold block mb-1">healing</span>
                        <span class="text-xl font-black text-slate-900 block font-mono">24</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase">Gejala Klinis</span>
                    </div>
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl text-center col-span-2">
                        <span class="material-symbols-outlined text-slate-700 text-2xl font-bold block mb-1">rule</span>
                        <span class="text-xl font-black text-slate-900 block font-mono">34</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase">Aturan Matriks Jurnal SINTA</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 3: FEATURES CONTAINER (ALUR DIAGNOSIS PART) -->
        <section id="features" class="bg-white rounded-2xl border border-[#bcc9c6] p-6 sm:p-10 shadow-xs">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <h2 class="text-xs font-bold tracking-widest text-[#00685f] uppercase">Panduan Layanan</h2>
                <p class="text-2xl font-extrabold tracking-tight text-slate-900 mt-2">3 Langkah Mudah Deteksi Dini</p>
                <div class="w-12 h-1 bg-[#00685f] mx-auto mt-3 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Langkah 1 -->
                <div class="p-5 bg-slate-50 border border-slate-200 rounded-xl">
                    <div
                        class="w-8 h-8 bg-[#00685f]/10 rounded-lg flex items-center justify-center text-[#00685f] mb-3 font-mono font-bold text-xs">
                        01
                    </div>
                    <h3 class="text-xs font-bold text-slate-900 mb-1">Pilih Keluhan Gejala</h3>
                    <p class="text-[11px] text-[#3d4947] leading-relaxed">
                        Masuk ke menu kuesioner dan centang serta pilih tingkat kondisi gejala fisik yang saat ini sedang
                        Anda rasakan pada area telinga, hidung, atau tenggorokan.
                    </p>
                </div>

                <!-- Langkah 2 -->
                <div class="p-5 bg-slate-50 border border-slate-200 rounded-xl">
                    <div
                        class="w-8 h-8 bg-[#924628]/10 rounded-lg flex items-center justify-center text-[#924628] mb-3 font-mono font-bold text-xs">
                        02
                    </div>
                    <h3 class="text-xs font-bold text-slate-900 mb-1">Kalkulasi Cerdas</h3>
                    <p class="text-[11px] text-[#3d4947] leading-relaxed">
                        Mesin sistem pakar Certainty Factor akan langsung mengolah dan mengkalkulasikan data keluhan Anda
                        secara real-time berdasarkan bobot pakar.
                    </p>
                </div>

                <!-- Langkah 3 -->
                <div class="p-5 bg-slate-50 border border-slate-200 rounded-xl">
                    <div
                        class="w-8 h-8 bg-slate-200 rounded-lg flex items-center justify-center text-slate-700 mb-3 font-mono font-bold text-xs">
                        03
                    </div>
                    <h3 class="text-xs font-bold text-slate-900 mb-1">Hasil &amp; Solusi</h3>
                    <p class="text-[11px] text-[#3d4947] leading-relaxed">
                        Hasil analisis cetak rekam medis akan langsung menampilkan persentase keyakinan penyakit tertinggi
                        beserta tips penanganan medisnya.
                    </p>
                </div>
            </div>
        </section>

    </div>
@endsection
