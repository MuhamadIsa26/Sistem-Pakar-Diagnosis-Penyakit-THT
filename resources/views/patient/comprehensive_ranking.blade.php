@extends('layouts.patient')

@section('title', 'Diagnosis Results | THT-Pedia')

@section('content')
    <!-- Google Fonts & Icons Link Setup -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        @media print {
            .print\:hidden {
                display: none !important;
            }
        }
    </style>

    <div class="bg-[#f5faf8] text-[#171d1c] font-sans antialiased min-h-screen">
        <main class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-6 md:py-10 flex flex-col gap-6 md:gap-8">

            <!-- =========================================================================
                                                             HEADER SECTION
                                     ========================================================================= -->
            <section class="flex-shrink-0">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-[#171d1c] tracking-tight">Diagnosis
                            Results</h1>
                        <p class="text-xs sm:text-sm text-[#3d4947] mt-1">Analysis completed based on your reported symptoms
                            and clinical history.</p>
                    </div>
                    <div
                        class="flex items-center gap-2.5 text-[#3d4947] bg-[#f0f5f2] px-3.5 py-2 rounded-xl border border-[#bcc9c6] w-full sm:w-auto self-start sm:self-auto justify-center sm:justify-start">
                        <span class="material-symbols-outlined text-[#00685f] text-lg animate-spin"
                            style="animation-duration: 3s;">schedule</span>
                        <span id="live-realtime-clock"
                            class="text-[11px] sm:text-xs font-semibold whitespace-nowrap text-slate-700">
                            Memuat Waktu Terkini...
                        </span>
                    </div>
                </div>
            </section>

            <!-- =========================================================================
                                                             CONTENT LAYOUT (2 COLUMNS)
                                     ========================================================================= -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 md:gap-8">
                <div class="lg:col-span-8 flex flex-col gap-6 md:gap-8">
                    <!-- 1. Primary Indication Card (RANK 1 - HIGH CONFIDENCE) -->
                    <div
                        class="bg-white border border-[#bcc9c6] rounded-2xl p-5 sm:p-6 md:p-8 shadow-sm relative overflow-hidden">
                        <div
                            class="block sm:absolute sm:top-0 sm:right-0 p-0 sm:p-6 mb-4 sm:mb-0 print:hidden text-left sm:text-right">
                            <span
                                class="bg-[#008378] text-[#f4fffc] px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider inline-block">
                                {{ $history->confidence_value >= 70 ? 'High Confidence' : ($history->confidence_value >= 45 ? 'Moderate Confidence' : 'Low Confidence') }}
                            </span>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start gap-4 sm:gap-6 mb-6">
                            <div
                                class="bg-[#6bd8cb]/20 text-[#00685f] p-3.5 rounded-xl border border-[#6bd8cb]/30 shrink-0">
                                <span class="material-symbols-outlined text-4xl sm:text-5xl">health_metrics</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] sm:text-xs font-bold text-[#00685f] uppercase tracking-wider mb-1">
                                    Primary Indication</p>
                                <h2
                                    class="text-xl sm:text-2xl md:text-3xl font-extrabold text-[#171d1c] tracking-tight break-words">
                                    {{ $history->disease?->name ?? 'Tidak Terdeteksi' }}
                                </h2>
                                <div class="flex flex-wrap items-baseline gap-2 mt-2 sm:mt-3">
                                    <span class="text-3xl sm:text-4xl md:text-5xl text-[#00685f] font-black tracking-tight">
                                        {{ number_format($history->confidence_value, 2) }}%
                                    </span>
                                    <span class="text-[11px] sm:text-xs font-semibold text-[#3d4947]">Certainty Factor
                                        (CF)</span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="text-[11px] sm:text-xs text-[#3d4947] bg-[#f5faf8] px-3.5 py-2 rounded-lg border border-[#dee4e1] inline-block mb-6 max-w-full truncate">
                            <span class="font-bold text-[#171d1c]">Pasien:</span> {{ $history->patient_name }}
                        </div>
                        <hr class="border-[#e4e9e7] my-5 sm:my-6" />

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                            <div>
                                <h4
                                    class="text-[11px] sm:text-xs font-bold text-[#171d1c] mb-2 sm:mb-3 flex items-center gap-1.5 uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-[#00685f] text-sm">info</span>
                                    Clinical Overview
                                </h4>
                                <p class="text-xs sm:text-sm text-[#3d4947] leading-relaxed">
                                    {{ $history->disease?->description ?? 'Tidak ada deskripsi rekam medis tambahan untuk hasil diagnosis ini.' }}
                                </p>
                            </div>
                            <div
                                class="bg-[#f0f5f2] p-4 sm:p-5 rounded-xl border border-[#bcc9c6] flex flex-col justify-between gap-4">
                                <div>
                                    <h4
                                        class="text-[9px] sm:text-[10px] font-bold text-[#3d4947] uppercase tracking-wider mb-2">
                                        Next Steps / Solusi</h4>
                                    <p class="text-xs text-[#3d4947] leading-relaxed">
                                        {{ $history->disease?->solution ?? 'Segera lakukan konsultasi konfirmasi luring dengan dokter spesialis THT terdekat untuk penanganan obat lebih lanjut.' }}
                                    </p>
                                </div>
                                <ul class="space-y-2 pt-2 border-t border-[#dee4e1]">
                                    <li class="flex items-center gap-2 text-xs font-medium text-[#171d1c]">
                                        <span
                                            class="material-symbols-outlined text-[#00685f] text-base shrink-0">check_circle</span>
                                        Hubungi Spesialis THT
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Differential Diagnosis Ranking -->
                    <div
                        class="bg-white border border-[#bcc9c6] rounded-2xl p-5 sm:p-6 md:p-8 shadow-sm flex flex-col gap-5 sm:gap-6">
                        <div class="flex flex-row items-center justify-between gap-2">
                            <h3 class="text-base sm:text-lg font-bold text-[#171d1c] tracking-tight truncate">Differential
                                Diagnosis Ranking</h3>
                            <div class="flex items-center gap-1 text-[#6d7a77] text-[11px] sm:text-xs shrink-0">
                                <span class="material-symbols-outlined text-sm">bar_chart</span>
                                <span class="font-semibold hidden sm:inline">Probabilistic Ranking</span>
                            </div>
                        </div>

                        <div class="space-y-3 sm:space-y-4">
                            @php
                                $allRanks = collect($history->diagnoses_rank ?? []);
                                $dbRankings = $allRanks->slice(1, 3);
                            @endphp

                            @forelse ($dbRankings as $rank)
                                @php
                                    $rankNumber = sprintf('%02d', $allRanks->search($rank) + 1);
                                    $cfValue = $rank['confidence_value'] ?? 0;
                                    $diseaseName = $rank['name'] ?? 'Penyakit Alternatif';

                                    $isModerate = $cfValue >= 50;
                                    $bgClass = $isModerate ? 'bg-[#f0f5f2]' : 'bg-[#f5faf8]';
                                    $barClass = $isModerate ? 'bg-[#00685f]' : 'bg-[#6d7a77] opacity-60';
                                    $badgeClass = $isModerate
                                        ? 'bg-[#dce0e4] text-[#5e6367]'
                                        : 'bg-[#e4e9e7] text-[#3d4947]';
                                    $numBgClass = $isModerate
                                        ? 'bg-[#00685f] text-white'
                                        : 'bg-[#bcc9c6] text-[#171d1c]';
                                    $statusText =
                                        $cfValue >= 70
                                            ? 'High Confidence'
                                            : ($cfValue >= 45
                                                ? 'Moderate Confidence'
                                                : 'Low Confidence');
                                @endphp

                                <!-- Item Card Rank -->
                                <div
                                    class="p-4 rounded-xl border border-[#bcc9c6] {{ $bgClass }} transition-all flex flex-col gap-3">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            <span
                                                class="w-7 h-7 rounded-full {{ $numBgClass }} flex items-center justify-center font-bold text-xs shrink-0">
                                                {{ $rankNumber }}
                                            </span>
                                            <span
                                                class="font-bold text-sm sm:text-base text-[#171d1c] truncate">{{ $diseaseName }}</span>
                                        </div>
                                        <span
                                            class="{{ $badgeClass }} px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider self-start sm:self-auto whitespace-nowrap">
                                            {{ $statusText }}
                                        </span>
                                    </div>
                                    <div class="w-full">
                                        <div class="flex justify-between mb-1 text-[11px] sm:text-xs">
                                            <span class="text-[#3d4947]">Matching Indicators</span>
                                            <span class="font-bold text-[#00685f]">{{ number_format($cfValue, 2) }}%
                                                Accuracy</span>
                                        </div>
                                        <div class="w-full bg-[#e4e9e7] rounded-full h-2 overflow-hidden">
                                            <div class="{{ $barClass }} h-full rounded-full"
                                                style="width: {{ $cfValue }}%;"></div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="p-6 text-center text-xs text-[#3d4947] bg-[#f5faf8] rounded-xl border border-dashed border-[#bcc9c6]">
                                    Tidak ada diferensiasi diagnosis alternatif yang terekam untuk riwayat ini.
                                </div>
                            @endforelse
                        </div>

                        <!-- 3. Extended Pathological Variance -->
                        <div class="mt-2">
                            <h4
                                class="text-[11px] sm:text-xs font-bold text-[#00685f] uppercase mb-2 sm:mb-3 tracking-wider">
                                Extended Pathological Variance</h4>
                            <div class="overflow-x-auto border border-[#bcc9c6] rounded-xl bg-white shadow-inner">
                                <table class="w-full text-left text-xs min-w-[400px]">
                                    <thead class="bg-[#eaefed] text-[#171d1c] font-bold">
                                        <tr>
                                            <th class="p-3.5 border-b border-[#bcc9c6]">Rank</th>
                                            <th class="p-3.5 border-b border-[#bcc9c6]">Code</th>
                                            <th class="p-3.5 border-b border-[#bcc9c6]">Condition</th>
                                            <th class="p-3.5 border-b border-[#bcc9c6] text-right">Probability</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#dee4e1]">
                                        @php
                                            $dbVariance = $allRanks->slice(4);
                                        @endphp

                                        @forelse ($dbVariance as $variance)
                                            @php
                                                $actualRank = sprintf('%02d', $allRanks->search($variance) + 1);
                                            @endphp
                                            <tr class="hover:bg-slate-50/50 transition-colors">
                                                <td class="p-3.5 text-[#3d4947]">{{ $actualRank }}</td>
                                                <td class="p-3.5 text-[#3d4947] font-mono">
                                                    {{ $variance['code'] ?? 'P000' }}</td>
                                                <td class="p-3.5 font-semibold text-[#171d1c] max-w-[180px] truncate">
                                                    {{ $variance['name'] ?? 'Penyakit Komparatif' }}</td>
                                                <td class="p-3.5 text-right font-bold text-[#00685f]">
                                                    {{ number_format($variance['confidence_value'] ?? 0, 1) }}%</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"
                                                    class="p-4 text-center text-[#3d4947] italic bg-[#f5faf8]">
                                                    Tidak ada data variansi patologis lanjutan (Rank 5+).
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="lg:col-span-4 flex flex-col gap-6 md:gap-8 w-full">

                    <!-- 4. Symptom Influence Box -->
                    <div class="bg-white border border-[#bcc9c6] rounded-xl p-5 sm:p-6 shadow-sm">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="material-symbols-outlined text-[#00685f] text-xl">analytics</span>
                            <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-[#171d1c]">Symptom
                                Influence</h3>
                        </div>
                        <p class="text-[11px] sm:text-xs text-[#3d4947] mb-4">Daftar bobot keyakinan yang Anda masukkan
                            untuk setiap gejala klinis aktif:</p>

                        <div class="space-y-2 max-h-[260px] sm:max-h-[320px] overflow-y-auto pr-1">
                            @if (!empty($history->symptoms))
                                @php
                                    $decodedSymptoms = json_decode($history->symptoms, true);
                                @endphp
                                @if (is_array($decodedSymptoms) && count($decodedSymptoms) > 0)
                                    @foreach ($decodedSymptoms as $symptomLog)
                                        <div
                                            class="flex items-center justify-between p-3 bg-[#f5faf8] rounded-xl border border-[#bcc9c6] gap-3">
                                            <div class="flex items-center gap-2 min-w-0">
                                                <span
                                                    class="material-symbols-outlined text-[#00685f] text-sm shrink-0">emergency</span>
                                                <span
                                                    class="text-xs font-medium text-[#171d1c] truncate">{{ $symptomLog['name'] ?? 'Gejala' }}</span>
                                            </div>
                                            <span
                                                class="text-xs font-bold text-[#00685f] shrink-0">+{{ $symptomLog['cf_user'] ?? '0.0' }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-6 text-xs text-[#3d4947] italic">Tidak ada gejala aktif.
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- 5. Medical Directives (Premium Action Card) -->
                    <div
                        class="bg-[#2c3130] text-[#edf2f0] rounded-xl p-5 sm:p-6 shadow-md flex flex-col justify-between gap-6">
                        <div class="space-y-5">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#6bd8cb] scale-110">verified_user</span>
                                <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wider">Medical Directives</h3>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <span
                                        class="text-[9px] sm:text-[10px] font-bold uppercase text-[#6bd8cb] block mb-1">Tindakan
                                        Awal</span>
                                    <p class="text-xs opacity-90 leading-relaxed">
                                        {{ $history->disease?->solution ?? 'Hindari pemicu alergi udara bebas dan istirahat yang cukup.' }}
                                    </p>
                                </div>
                                <hr class="border-[#6d7a77] opacity-30" />
                                <div>
                                    <span
                                        class="text-[9px] sm:text-[10px] font-bold uppercase text-[#dfe3e7] block mb-1">Validasi
                                        Klinis</span>
                                    <p class="text-xs opacity-90 leading-relaxed">Cetak hasil enkripsi rekam medis mandiri
                                        ini dan tunjukkan pada dokter THT saat pemeriksaan fisik offline.</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 print:hidden">
                            <button onclick="window.print()"
                                class="w-full bg-[#008378] text-[#f4fffc] font-bold text-xs py-3 rounded-xl hover:bg-[#00685f] transition-all flex items-center justify-center gap-2 shadow-sm cursor-pointer active:scale-95 min-h-[44px]">
                                <span class="material-symbols-outlined text-sm">print</span> Cetak Laporan Lengkap
                            </button>
                        </div>
                    </div>
                </aside>
            </div>

            <!-- =========================================================================
                                                             FOOTNOTE SECTION (DISCLAIMER)
                                     ========================================================================= -->
            <section class="mt-4 border-t border-[#bcc9c6] pt-5 flex-shrink-0">
                <div class="flex flex-col md:flex-row gap-4 items-start md:items-center justify-between">
                    <div class="max-w-4xl">
                        <h4 class="text-[11px] sm:text-xs font-bold text-[#171d1c] mb-1 uppercase tracking-wider">AI &
                            Expert System Methodology Disclaimer</h4>
                        <p class="text-[10px] sm:text-[11px] text-[#3d4947] leading-relaxed">
                            Hasil rekam medis elektronik ini dibuat otomatis oleh Sistem Pakar THT-Pedia menggunakan metode
                            inferensi komparatif Certainty Factor. Laporan ini murni berfungsi sebagai alat bantu skrining
                            awal (skala prioritas indikasi klinis) and bukan merupakan pengganti mutlak resep dokter berizin
                            spesialis.
                        </p>
                    </div>
                    <div class="flex gap-3 print:hidden self-end md:self-auto shrink-0">
                        <a href="{{ route('patient.history') }}"
                            class="p-2.5 rounded-full border border-[#6d7a77] bg-white hover:bg-[#dee4e1] transition-all flex items-center justify-center text-[#3d4947] shadow-sm min-w-[40px] min-h-[40px]">
                            <span class="material-symbols-outlined text-base">history</span>
                        </a>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- =========================================================================
                                                 JAVASCRIPT REAL-TIME CLOCK ENGINE
                     ========================================================================= -->
    <script>
        function renderLiveClock() {
            const now = new Date();

            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            };

            let liveString = new Intl.DateTimeFormat('id-ID', options).format(now);
            liveString = liveString.replace(/\./g, ':');
            document.getElementById('live-realtime-clock').textContent = `Waktu Sistem: ${liveString} WIB`;
        }

        setInterval(renderLiveClock, 1000);
        renderLiveClock();
    </script>
@endsection
