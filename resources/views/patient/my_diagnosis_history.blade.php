@extends('layouts.patient')

@section('title', 'Your Assessment History | THT-Pedia')

@section('content')
    <!-- Google Fonts & Icons Link Setup -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        .medical-card-shadow {
            box-shadow: 0px 2px 4px rgba(13, 148, 136, 0.05);
        }
    </style>

    <div class="bg-[#f5faf8] text-[#171d1c] font-sans antialiased min-h-screen">
        <!-- Responsive Container Padding -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-6 md:py-10 flex flex-col gap-6 md:gap-8">

            <!-- =========================================================================
                                             HEADER SECTION
                     ========================================================================= -->
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                <div class="space-y-2">
                    <h1
                        class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-[#171d1c] tracking-tight break-words">
                        Your Assessment History
                    </h1>
                    <p class="text-sm md:text-base text-[#3d4947] max-w-2xl leading-relaxed">
                        Review your previous symptom checks and clinical evaluations. Download detailed reports for your
                        next doctor's visit.
                    </p>
                </div>
                <!-- Action Buttons: Full-width on mobile, auto-width on desktop -->
                <div class="flex flex-row items-center gap-3 w-full lg:w-auto shrink-0">
                    <button
                        class="flex-1 lg:flex-none flex items-center justify-center gap-2 px-4 sm:px-5 py-3 bg-[#e4e9e7] text-[#171d1c] border border-[#bcc9c6] rounded-xl font-semibold text-xs sm:text-sm hover:bg-[#dee4e1] transition-all min-h-[44px]">
                        <span class="material-symbols-outlined text-[18px] sm:text-[20px]">filter_list</span>
                        Filter
                    </button>
                    <a href="{{ route('patient.diagnosis.questionnaire') }}"
                        class="flex-1 lg:flex-none flex items-center justify-center gap-2 px-4 sm:px-5 py-3 bg-[#00685f] text-white rounded-xl font-semibold text-xs sm:text-sm hover:bg-[#008378] transition-all active:scale-95 shadow-sm min-h-[44px]">
                        <span class="material-symbols-outlined text-[18px] sm:text-[20px]">add</span>
                        <span class="truncate">New Assessment</span>
                    </a>
                </div>
            </div>

            <!-- =========================================================================
                                             HISTORY GRID SYSTEM
                     ========================================================================= -->
            <!-- Adjusted layout breakpoints: 1 col on mobile, 2 cols on tablet, 3 cols on desktop -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">

                @forelse($histories as $history)
                    @php
                        $cfValue = $history->confidence_value ?? 0;
                        $isHigh = $cfValue >= 70;
                        $statusColorClass = $isHigh ? 'text-[#00685f]' : 'text-[#5a5f62]';
                        $barColorClass = $isHigh ? 'bg-[#00685f]' : 'bg-[#5a5f62]';
                        $iconName = $isHigh ? 'verified' : 'info';
                    @endphp

                    <!-- Entry Card Dynamic -->
                    <div
                        class="bg-white border border-slate-200 rounded-2xl medical-card-shadow overflow-hidden flex flex-col group hover:border-[#00685f] transition-all duration-200">
                        <div class="p-5 sm:p-6 flex-grow">
                            <div class="flex justify-between items-start mb-4 gap-2">
                                <span
                                    class="px-3 py-1 bg-[#eaefed] text-[#3d4947] font-medium text-xs rounded-full whitespace-nowrap">
                                    {{ $history->created_at->translatedFormat('M d, Y') }}
                                </span>
                                <!-- Touch Target Friendly Icons -->
                                <a href="{{ route('patient.diagnosis.result', $history->id) }}?print=true"
                                    class="material-symbols-outlined text-[#6d7a77] hover:text-[#00685f] transition-colors p-1 -mt-1 -mr-1"
                                    title="Download Report">
                                    download
                                </a>
                            </div>

                            <h3
                                class="text-lg sm:text-xl font-bold text-[#171d1c] mb-2 tracking-tight group-hover:text-[#00685f] transition-colors break-words">
                                {{ $history->disease?->name ?? 'Unknown Condition' }}
                            </h3>

                            <div class="flex items-center gap-1.5 mb-4">
                                <div class="flex items-center gap-1 {{ $statusColorClass }} min-w-0">
                                    <span class="material-symbols-outlined text-[18px] shrink-0"
                                        style="font-variation-settings: 'FILL' 1;">{{ $iconName }}</span>
                                    <span
                                        class="text-[11px] font-bold uppercase tracking-wider truncate">{{ number_format($cfValue, 1) }}%
                                        Confidence</span>
                                </div>
                            </div>

                            <!-- Bar Metrik Indikator CF -->
                            <div class="h-1.5 w-full bg-[#eaefed] rounded-full overflow-hidden mb-2">
                                <div class="h-full {{ $barColorClass }} rounded-full" style="width: {{ $cfValue }}%;">
                                </div>
                            </div>
                        </div>

                        <!-- Footer Card Info -->
                        <div
                            class="px-5 sm:px-6 py-4 bg-[#f8faf9] border-t border-slate-100 flex items-center justify-between gap-2">
                            <a href="{{ route('patient.diagnosis.result', $history->id) }}"
                                class="text-[#00685f] font-bold text-xs hover:underline decoration-2 underline-offset-4 flex items-center gap-1 min-h-[32px]">
                                View Full Report
                                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                            </a>
                            <span class="text-[11px] font-mono font-bold text-[#6d7a77] truncate">
                                Ref: #{{ $history->disease?->code ?? 'P000' }}-{{ $history->id }}
                            </span>
                        </div>
                    </div>
                @empty
                    <!-- Tampilan Kosong Dialihkan ke Blok Awal Tombol Add -->
                @endforelse

                <!-- Empty State / Add New Placeholder Box -->
                <a href="{{ route('patient.diagnosis.questionnaire') }}"
                    class="border-2 border-dashed border-[#bcc9c6] rounded-2xl flex flex-col items-center justify-center p-6 sm:p-8 min-h-[220px] group hover:border-[#00685f] hover:bg-[#f0f5f2] transition-all cursor-pointer text-center">
                    <div
                        class="w-12 h-12 rounded-full bg-[#eaefed] flex items-center justify-center mb-4 group-hover:bg-[#008378] group-hover:text-white transition-all">
                        <span class="material-symbols-outlined text-[32px]">add_circle</span>
                    </div>
                    <p class="text-base sm:text-lg font-bold text-[#3d4947] group-hover:text-[#00685f] transition-all">Start
                        New Check
                    </p>
                    <p class="text-xs text-[#6d7a77] mt-1 max-w-[200px]">Check current symptoms for immediate clinical
                        guidance.</p>
                </a>
            </div>

            <!-- =========================================================================
                                             INFO SECTION (BENTO STYLE)
                     ========================================================================= -->
            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                <!-- Kebijakan Privasi Data -->
                <div
                    class="md:col-span-2 bg-[#008378]/5 border border-[#00685f]/20 rounded-2xl p-5 sm:p-6 flex flex-col sm:flex-row items-start gap-4">
                    <div class="bg-[#00685f] text-white p-3 rounded-xl shadow-sm shrink-0 mx-auto sm:mx-0">
                        <span class="material-symbols-outlined">health_and_safety</span>
                    </div>
                    <div class="text-center sm:text-left">
                        <h4 class="text-base font-bold text-[#00685f] mb-1">Your Privacy Matters</h4>
                        <p class="text-xs sm:text-sm text-[#3d4947] leading-relaxed">
                            All assessment data is encrypted and HIPAA compliant. Only verified medical practitioners with
                            your explicit permission can access these detailed records.
                        </p>
                    </div>
                </div>

                <!-- Status Panel Sistem Pakar -->
                <div
                    class="bg-[#b05e3d] text-white rounded-2xl p-5 sm:p-6 flex flex-col justify-center border border-[#924628]/20 shadow-sm text-center sm:text-left">
                    <p class="text-[10px] font-bold uppercase tracking-wider opacity-80 mb-1">Current Status</p>
                    <p class="text-lg sm:text-xl font-bold tracking-tight">System Optimal</p>
                    <p class="text-xs mt-2 opacity-95 font-medium">Last updated: Today, {{ now()->format('H:i') }} WIB</p>
                </div>
            </div>

        </main>
    </div>
@endsection
