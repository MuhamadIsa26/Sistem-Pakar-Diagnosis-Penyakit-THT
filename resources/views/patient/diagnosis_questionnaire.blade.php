@extends('layouts.patient')

@section('title', 'Kuesioner Gejala Klinis THT')

@section('content')
    <!-- Failsafe CDN Alpine.js & Google Icons jika di layout utama belum terpasang -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- CSS Khusus untuk mencegah kilatan data (anti-flicker) saat page load -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Custom scrollbar halus untuk container gejala aktif */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }
    </style>

    <!-- Alpine.js SPA Page Engine -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-slate-800" x-data="{
        step: 1,
        search: '',
        selectedSymptoms: [],
    
        // Model Data Validasi Halaman 1
        nama: '{{ auth()->user()->nama ?? (auth()->user()->name ?? '') }}',
        nim: '{{ auth()->user()->nim ?? '' }}',
        gender: '',
        umur: '',
        telepon: '',
    
        // State Pengontrol Alert dan Konfirmasi Modal
        showAlert: false,
        alertMessage: '',
        showConfirm: false,
    
        // Fungsi Validasi Tahap 1: Memastikan Data Wajib Terisi Semua
        isStep1Valid() {
            return this.nama.trim() !== '' && this.gender !== '' && this.umur !== '' && this.telepon.trim() !== '';
        },
    
        // Fungsi Validasi Tahap 2: Memastikan Semua Radio Grup Terjawab
        isStep2Valid() {
            let totalRadioGroups = {{ count($symptoms) }};
            if (totalRadioGroups === 0) return false;
            let totalAnswered = document.querySelectorAll('.gejala-radio:checked').length;
            return totalAnswered === totalRadioGroups;
        },
    
        // Pengontrol Perpindahan Halaman Berbasis Interogasi Keamanan Validasi
        goToStep(targetStep) {
            if (targetStep === 2) {
                if (!this.isStep1Valid()) {
                    this.alertMessage = 'Silakan lengkapi seluruh Data Personal (Nama, Umur, Gender, dan Telepon) pada Langkah 1 terlebih dahulu.';
                    this.showAlert = true;
                    return;
                }
                this.step = 2;
            } else if (targetStep === 3) {
                if (!this.isStep1Valid()) {
                    this.alertMessage = 'Silakan lengkapi seluruh Data Personal pada Langkah 1 terlebih dahulu.';
                    this.showAlert = true;
                    return;
                }
                if (!this.isStep2Valid()) {
                    this.alertMessage = 'Silakan tentukan tingkat keyakinan klinis untuk setiap gejala pada Langkah 2 terlebih dahulu.';
                    this.showAlert = true;
                    return;
                }
                this.updateReview();
                this.step = 3;
            } else if (targetStep === 1) {
                this.step = 1;
            }
        },
    
        // Memicu Tampilan Dialog Konfirmasi Sebelum Submit
        submitForm() {
            if (!this.isStep1Valid() || !this.isStep2Valid()) {
                this.alertMessage = 'Seluruh tahapan form kuesioner wajib dilengkapi secara valid sebelum memproses hasil.';
                this.showAlert = true;
                return;
            }
            this.showConfirm = true;
        },
    
        updateReview() {
            this.selectedSymptoms = [];
            document.querySelectorAll('.gejala-radio:checked').forEach(radio => {
                let val = radio.value;
                if (val !== 'tidak') {
                    let card = radio.closest('.gejala-card');
                    let code = card.getAttribute('data-code');
                    let name = card.getAttribute('data-name');
                    let text = radio.getAttribute('data-label');
                    this.selectedSymptoms.push({ code: code, name: name, label: text, value: val });
                }
            });
        },
    
        getProgressPercent() {
            let totalRadioGroups = {{ count($symptoms) }};
            if (totalRadioGroups === 0) return 0;
            let totalAnswered = document.querySelectorAll('.gejala-radio:checked').length;
            return Math.round((totalAnswered / totalRadioGroups) * 100);
        }
    }">

        <!-- Layout Wrapper: Stacked on Mobile, Row on Desktop -->
        <div class="flex flex-col lg:flex-row gap-6 items-start">

            <!-- =========================================================================
                                                 SIDEBAR FLOW NAVIGATION (WIZARD STEPPER)
                                                 ========================================================================= -->
            <aside class="w-full lg:w-1/4 flex flex-col sm:flex-row lg:flex-col gap-4 static lg:sticky lg:top-24 z-10">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex-1">
                    <h3 class="text-xs font-bold text-[#00685f] mb-4 lg:mb-5 tracking-tight uppercase hidden sm:block">
                        Assessment Flow</h3>

                    <!-- Stepper Container -->
                    <div
                        class="flex flex-row lg:flex-col justify-between lg:justify-start items-center lg:items-start gap-2 lg:gap-1 overflow-x-auto lg:overflow-x-visible pb-2 sm:pb-0">

                        <!-- Halaman 1 Link -->
                        <div class="flex items-center gap-2 lg:gap-3 cursor-pointer shrink-0" @click="goToStep(1)">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 shrink-0"
                                :class="step > 1 ? 'bg-[#00685f] text-white' :
                                    'border-2 border-[#00685f] bg-[#00685f]/10 text-[#00685f] font-black'">
                                <span x-show="step > 1" class="material-symbols-outlined text-sm font-bold">check</span>
                                <span x-show="step === 1">1</span>
                            </div>
                            <span class="text-xs font-semibold hidden sm:inline"
                                :class="step === 1 ? 'text-[#00685f] font-bold' : 'text-slate-800 font-semibold'">Personal
                                Info</span>
                        </div>

                        <!-- Connector Line -->
                        <div class="w-full h-px lg:w-px lg:h-6 bg-slate-200 my-0.5"></div>

                        <!-- Halaman 2 Link -->
                        <div class="flex items-center gap-2 lg:gap-3 cursor-pointer shrink-0" @click="goToStep(2)">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 shrink-0"
                                :class="step > 2 ? 'bg-[#00685f] text-white' : (step === 2 ?
                                    'border-2 border-[#00685f] bg-[#00685f]/10 text-[#00685f] font-black' :
                                    'bg-slate-100 text-slate-400')">
                                <span x-show="step > 2" class="material-symbols-outlined text-sm font-bold">check</span>
                                <span x-show="step <= 2">2</span>
                            </div>
                            <span class="text-xs font-semibold hidden sm:inline"
                                :class="step === 2 ? 'text-[#00685f] font-bold' : (step > 2 ? 'text-slate-800 font-semibold' :
                                    'text-slate-400')">Symptom
                                Check</span>
                        </div>

                        <!-- Connector Line -->
                        <div class="w-full h-px lg:w-px lg:h-6 bg-slate-200 my-0.5"></div>

                        <!-- Halaman 3 Link -->
                        <div class="flex items-center gap-2 lg:gap-3 cursor-pointer shrink-0" @click="goToStep(3)">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 shrink-0"
                                :class="step === 3 ? 'border-2 border-[#00685f] bg-[#00685f]/10 text-[#00685f] font-black' :
                                    'bg-slate-100 text-slate-400'">
                                <span>3</span>
                            </div>
                            <span class="text-xs font-semibold text-slate-400 hidden sm:inline"
                                :class="step === 3 ? 'text-[#00685f] font-bold' : ''">Review</span>
                        </div>
                    </div>
                </div>

                <!-- Expert Note -->
                <div
                    class="bg-orange-50 p-4 rounded-xl border border-orange-200/60 shadow-sm hidden sm:block flex-1 lg:flex-initial">
                    <div class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-orange-700 text-lg shrink-0">info</span>
                        <div>
                            <p class="text-xs font-bold text-orange-950">Expert Note</p>
                            <p class="text-[11px] text-orange-800 mt-1 leading-relaxed">
                                Please provide your level of certainty for each symptom to improve diagnosis accuracy.
                            </p>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- =========================================================================
                                                 MAIN WORKSPACE
                                                 ========================================================================= -->
            <section class="flex-1 w-full">
                <div class="bg-white p-4 sm:p-6 md:p-8 rounded-xl shadow-sm border border-slate-200">

                    <form action="{{ route('patient.diagnosis.process') }}" method="POST" id="questionnaire-form">
                        @csrf

                        <!-- =========================================================================
                                                             MODAL DIALOG DI ATAS FORM
                                                             ========================================================================= -->
                        <!-- 1. ALERT DIALOG (Form Incomplete Warning) -->
                        <div x-show="showAlert" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs"
                            x-transition>
                            <div
                                class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl border border-slate-200 text-center relative overflow-hidden">
                                <div class="absolute top-0 left-0 right-0 h-1.5 bg-amber-500"></div>
                                <div
                                    class="mb-4 inline-flex items-center justify-center w-12 h-12 bg-amber-50 text-amber-600 rounded-full">
                                    <span class="material-symbols-outlined text-2xl font-bold">warning</span>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900 mb-2">Formulir Belum Lengkap</h3>
                                <p class="text-xs text-slate-600 leading-relaxed mb-6" x-text="alertMessage"></p>
                                <button type="button" @click="showAlert = false"
                                    class="w-full py-2.5 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
                                    Mengerti
                                </button>
                            </div>
                        </div>

                        <!-- 2. CONFIRMATION DIALOG (Apakah sudah yakin, YA/TIDAK) -->
                        <div x-show="showConfirm" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs"
                            x-transition>
                            <div
                                class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl border border-slate-200 text-center relative overflow-hidden">
                                <div class="absolute top-0 left-0 right-0 h-1.5 bg-[#00685f]"></div>
                                <div
                                    class="mb-4 inline-flex items-center justify-center w-12 h-12 bg-[#f0f5f2] text-[#00685f] rounded-full">
                                    <span class="material-symbols-outlined text-2xl font-bold">help</span>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900 mb-2">Konfirmasi Diagnosis</h3>
                                <p class="text-xs text-slate-600 leading-relaxed mb-6">Apakah Anda sudah yakin dengan semua
                                    data personal dan gejala klinis yang Anda masukkan? Hasil akan segera diproses oleh
                                    sistem pakar Certainty Factor.</p>
                                <div class="flex gap-2">
                                    <button type="button" @click="showConfirm = false"
                                        class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors cursor-pointer">
                                        Tidak
                                    </button>
                                    <button type="submit"
                                        class="flex-1 py-2.5 bg-[#00685f] hover:bg-[#008378] text-white text-xs font-bold rounded-xl transition-colors shadow-sm cursor-pointer">
                                        Ya, Proses
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- =========================================================================
                                                             HALAMAN 1: PERSONAL INFO
                                                             ========================================================================= -->
                        <div x-show="step === 1" class="space-y-6">
                            <div class="border-b border-slate-100 pb-4">
                                <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Personal Information
                                </h1>
                                <p class="text-xs text-slate-500 mt-0.5">Lengkapi data rekam medis Anda di bawah untuk
                                    membuka tahap pemeriksaan gejala.</p>
                            </div>

                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 bg-slate-50/50 p-4 sm:p-5 rounded-xl border border-slate-200/60">
                                <div class="sm:col-span-2">
                                    <label
                                        class="block text-[10px] font-bold uppercase text-slate-400 tracking-wider mb-1.5">Nama
                                        Lengkap</label>
                                    <input type="text" name="patient_name" x-model="nama"
                                        placeholder="Masukkan nama lengkap Anda" required
                                        class="w-full px-3 py-2.5 text-xs bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#00685f] focus:border-[#00685f] transition-all text-slate-800 font-medium">
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-bold uppercase text-slate-400 tracking-wider mb-1.5">Nomor
                                        Induk / NIM</label>
                                    <input type="text" x-model="nim" placeholder="Contoh: 23176032"
                                        class="w-full px-3 py-2.5 text-xs bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#00685f] focus:border-[#00685f] transition-all text-slate-800 font-mono">
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-bold uppercase text-slate-400 tracking-wider mb-1.5">Umur
                                        (Tahun)</label>
                                    <input type="number" x-model="umur" placeholder="Contoh: 21" min="1"
                                        max="120"
                                        class="w-full px-3 py-2.5 text-xs bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#00685f] focus:border-[#00685f] transition-all text-slate-800 font-medium">
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-bold uppercase text-slate-400 tracking-wider mb-1.5">Jenis
                                        Kelamin</label>
                                    <div class="flex gap-2">
                                        <label
                                            class="flex-1 text-center py-2.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-600 bg-white hover:border-[#00685f] transition-all cursor-pointer has-[:checked]:bg-[#00685f] has-[:checked]:text-white has-[:checked]:border-[#00685f]">
                                            <input type="radio" x-model="gender" value="Laki-laki" class="sr-only">
                                            Laki-Laki
                                        </label>
                                        <label
                                            class="flex-1 text-center py-2.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-600 bg-white hover:border-[#00685f] transition-all cursor-pointer has-[:checked]:bg-[#00685f] has-[:checked]:text-white has-[:checked]:border-[#00685f]">
                                            <input type="radio" x-model="gender" value="Perempuan" class="sr-only">
                                            Perempuan
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-bold uppercase text-slate-400 tracking-wider mb-1.5">Nomor
                                        Telepon / WA</label>
                                    <input type="text" x-model="telepon" placeholder="Contoh: 081234567xxx"
                                        class="w-full px-3 py-2.5 text-xs bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#00685f] focus:border-[#00685f] transition-all text-slate-800 font-medium">
                                </div>
                            </div>

                            <div class="mt-8 pt-4 border-t border-slate-100 flex justify-end">
                                <button type="button" @click="goToStep(2)"
                                    class="w-full sm:w-auto justify-center px-5 py-2.5 text-xs font-bold text-white bg-[#00685f] hover:bg-[#00685f]/90 rounded-lg transition-all flex items-center gap-1.5 shadow-sm active:scale-95 cursor-pointer">
                                    Next: Symptom Check
                                    <span class="material-symbols-outlined text-sm font-bold">arrow_forward</span>
                                </button>
                            </div>
                        </div>

                        <!-- =========================================================================
                                                             HALAMAN 2: SYMPTOM CHECK
                                                             ========================================================================= -->
                        <div x-show="step === 2" x-cloak class="space-y-6">
                            <div
                                class="flex flex-col sm:flex-row sm:items-end justify-between border-b border-slate-100 pb-4 gap-4">
                                <div>
                                    <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Symptom
                                        Selection</h1>
                                    <p class="text-xs text-slate-500 mt-0.5">Select common ENT (THT) symptoms and your
                                        certainty level.</p>
                                </div>
                                <div class="text-left sm:text-right w-full sm:w-48 shrink-0">
                                    <div class="flex justify-between mb-1 text-[10px] font-bold text-[#00685f]">
                                        <span>Progress Pengisian</span>
                                        <span x-text="getProgressPercent() + '%'"></span>
                                    </div>
                                    <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-[#00685f] transition-all duration-300"
                                            :style="'width: ' + getProgressPercent() + '%'"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="relative w-full">
                                <span
                                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                                <input type="text" x-model="search" placeholder="Cari gejala klinis di sini..."
                                    class="w-full pl-9 pr-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:bg-white focus:ring-1 focus:ring-[#00685f] focus:border-[#00685f] transition-all text-slate-800">
                            </div>

                            <!-- Symptom Cards Grid -->
                            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                                @foreach ($symptoms as $symptom)
                                    <div class="gejala-card bg-slate-50/50 hover:bg-slate-50 p-4 rounded-xl border border-slate-200/70 transition-colors flex flex-col gap-4"
                                        data-code="{{ $symptom->code }}" data-name="{{ $symptom->name }}"
                                        x-show="search === '' || '{{ strtolower($symptom->name) }}'.includes(search.toLowerCase())">
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <span
                                                    class="px-1.5 py-0.5 bg-white font-mono text-[9px] font-bold text-slate-400 rounded border border-slate-200 shrink-0">
                                                    {{ $symptom->code }}
                                                </span>
                                                <h4 class="text-xs font-bold text-slate-900 break-words">
                                                    {{ $symptom->name }}</h4>
                                            </div>
                                            <p class="text-[11px] text-slate-400 leading-normal">Tentukan tingkat keyakinan
                                                klinis Anda mengenai gejala ini.</p>
                                        </div>

                                        <div
                                            class="grid grid-cols-2 sm:grid-cols-3 gap-1.5 mt-auto pt-2.5 border-t border-slate-200/40">
                                            <label
                                                class="p-2 rounded border border-slate-200 text-[10px] font-medium text-slate-600 bg-white hover:border-[#00685f] transition-all text-center cursor-pointer has-[:checked]:bg-[#00685f] has-[:checked]:text-white has-[:checked]:border-[#00685f] flex items-center justify-center">
                                                <input type="radio" name="symptoms[{{ $symptom->id }}]"
                                                    value="sangat_yakin" data-label="Sangat Yakin"
                                                    class="sr-only gejala-radio" @change="updateReview()"> Sangat Yakin
                                            </label>
                                            <label
                                                class="p-2 rounded border border-slate-200 text-[10px] font-medium text-slate-600 bg-white hover:border-[#00685f] transition-all text-center cursor-pointer has-[:checked]:bg-[#00685f] has-[:checked]:text-white has-[:checked]:border-[#00685f] flex items-center justify-center">
                                                <input type="radio" name="symptoms[{{ $symptom->id }}]"
                                                    value="yakin" data-label="Yakin" class="sr-only gejala-radio"
                                                    @change="updateReview()"> Yakin
                                            </label>
                                            <label
                                                class="p-2 rounded border border-slate-200 text-[10px] font-medium text-slate-600 bg-white hover:border-[#00685f] transition-all text-center cursor-pointer has-[:checked]:bg-[#00685f] has-[:checked]:text-white has-[:checked]:border-[#00685f] flex items-center justify-center">
                                                <input type="radio" name="symptoms[{{ $symptom->id }}]"
                                                    value="cukup_yakin" data-label="Cukup Yakin"
                                                    class="sr-only gejala-radio" @change="updateReview()"> Cukup Yakin
                                            </label>
                                            <label
                                                class="p-2 rounded border border-slate-200 text-[10px] font-medium text-slate-600 bg-white hover:border-[#00685f] transition-all text-center cursor-pointer has-[:checked]:bg-[#00685f] has-[:checked]:text-white has-[:checked]:border-[#00685f] flex items-center justify-center">
                                                <input type="radio" name="symptoms[{{ $symptom->id }}]"
                                                    value="kurang_yakin" data-label="Kurang Yakin"
                                                    class="sr-only gejala-radio" @change="updateReview()"> Kurang Yakin
                                            </label>
                                            <label
                                                class="p-2 rounded border border-slate-200 text-[10px] font-medium text-slate-600 bg-white hover:border-[#00685f] transition-all text-center cursor-pointer has-[:checked]:bg-[#00685f] has-[:checked]:text-white has-[:checked]:border-[#00685f] flex items-center justify-center">
                                                <input type="radio" name="symptoms[{{ $symptom->id }}]"
                                                    value="tidak_tahu" data-label="Tidak Tahu"
                                                    class="sr-only gejala-radio" @change="updateReview()"> Tidak Tahu
                                            </label>
                                            <label
                                                class="p-2 rounded border border-slate-200 text-[10px] font-medium text-slate-500 bg-slate-100 hover:border-rose-400 transition-all text-center cursor-pointer has-[:checked]:bg-rose-600 has-[:checked]:text-white has-[:checked]:border-rose-600 flex items-center justify-center">
                                                <input type="radio" name="symptoms[{{ $symptom->id }}]"
                                                    value="tidak" data-label="Tidak" class="sr-only gejala-radio"
                                                    checked @change="updateReview()"> Tidak
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div
                                class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8 pt-4 border-t border-slate-100">
                                <button type="button" @click="goToStep(1)"
                                    class="w-full sm:w-auto flex items-center justify-center gap-1 text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors cursor-pointer py-2">
                                    <span class="material-symbols-outlined text-sm font-bold">arrow_back</span> Back to
                                    Info
                                </button>
                                <div class="flex gap-2 w-full sm:w-auto">
                                    <button type="button"
                                        class="flex-1 sm:flex-initial px-4 py-2.5 border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg transition-colors">Save
                                        Draft</button>
                                    <button type="button" @click="goToStep(3)"
                                        class="flex-1 sm:flex-initial justify-center px-5 py-2.5 text-xs font-bold text-white bg-[#00685f] hover:bg-[#00685f]/90 rounded-lg transition-all flex items-center gap-1.5 shadow-sm cursor-pointer active:scale-95">
                                        Review
                                        <span class="material-symbols-outlined text-sm font-bold">arrow_forward</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- =========================================================================
                                                             HALAMAN 3: REVIEW
                                                             ========================================================================= -->
                        <div x-show="step === 3" x-cloak class="space-y-6">
                            <div class="border-b border-slate-100 pb-4">
                                <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Review Assessment
                                </h1>
                                <p class="text-xs text-slate-500 mt-0.5">Tinjau ulang kecocokan data personal dan daftar
                                    gejala aktif Anda sebelum diproses oleh sistem pakar.</p>
                            </div>

                            <!-- Patient Metadata Box Grid -->
                            <div
                                class="p-4 bg-slate-50 border border-slate-200/60 rounded-xl grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-xs">
                                <div>
                                    <span class="block text-[10px] text-slate-400 font-bold uppercase">Nama Pasien</span>
                                    <span class="font-bold text-slate-800 break-words" x-text="nama"></span>
                                </div>
                                <div>
                                    <span class="block text-[10px] text-slate-400 font-bold uppercase">NIM / ID</span>
                                    <span class="font-mono text-slate-700 break-words" x-text="nim ? nim : '-'"></span>
                                </div>
                                <div>
                                    <span class="block text-[10px] text-slate-400 font-bold uppercase">Umur / Gender</span>
                                    <span class="font-medium text-slate-800"
                                        x-text="(umur ? umur : '-') + ' Thn / ' + (gender ? gender : '-')"></span>
                                </div>
                                <div>
                                    <span class="block text-[10px] text-slate-400 font-bold uppercase">Kontak</span>
                                    <span class="font-medium text-slate-800 break-words"
                                        x-text="telepon ? telepon : '-'"></span>
                                </div>
                            </div>

                            <!-- Selected Active Symptoms Container -->
                            <div class="space-y-2">
                                <h4 class="text-[11px] font-bold uppercase text-slate-400 tracking-wider">Gejala Aktif
                                    Terpilih:</h4>
                                <div class="max-h-[300px] overflow-y-auto pr-1 space-y-2 custom-scrollbar">
                                    <template x-for="item in selectedSymptoms" :key="item.code">
                                        <div
                                            class="flex items-center justify-between gap-4 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                                            <div class="flex items-center gap-2.5 min-w-0">
                                                <span
                                                    class="px-2 py-0.5 bg-white font-mono text-[10px] font-bold border border-slate-200 rounded text-slate-500 shrink-0"
                                                    x-text="item.code"></span>
                                                <span class="text-xs font-bold text-slate-800 truncate"
                                                    x-text="item.name"></span>
                                            </div>
                                            <span
                                                class="px-2.5 py-1 bg-[#00685f]/10 border border-[#00685f]/10 text-[#00685f] font-bold text-[10px] rounded-lg shadow-inner shrink-0"
                                                x-text="item.label"></span>
                                        </div>
                                    </template>
                                </div>

                                <div x-show="selectedSymptoms.length === 0"
                                    class="text-center py-10 border border-dashed border-slate-200 rounded-xl text-slate-400 text-xs font-medium">
                                    <span
                                        class="material-symbols-outlined text-3xl opacity-30 block mb-1">layers_clear</span>
                                    Seluruh kuesioner gejala Anda set sebagai 'Tidak'.
                                </div>
                            </div>

                            <div
                                class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8 pt-4 border-t border-slate-100">
                                <button type="button" @click="goToStep(2)"
                                    class="w-full sm:w-auto flex items-center justify-center gap-1 text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors cursor-pointer py-2">
                                    <span class="material-symbols-outlined text-sm font-bold">arrow_back</span> Ubah
                                    Pilihan Gejala
                                </button>
                                <button type="button" @click="submitForm()"
                                    class="w-full sm:w-auto justify-center px-5 py-2.5 text-xs font-bold text-white bg-[#00685f] hover:bg-[#008378] rounded-lg transition-all flex items-center gap-1.5 shadow-md cursor-pointer active:scale-95">
                                    Process Results
                                    <span class="material-symbols-outlined text-sm font-bold">science</span>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection
