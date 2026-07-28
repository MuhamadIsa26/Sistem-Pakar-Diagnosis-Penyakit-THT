<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>THT-Pedia | Dasbor Klinis Pasien</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "outline-variant": "#bcc9c6",
                        "surface-container-low": "#f0f5f2",
                        "on-surface": "#171d1c",
                        "on-surface-variant": "#3d4947",
                        "inverse-surface": "#2c3130",
                        "inverse-on-surface": "#edf2f0",
                        "primary": "#00685f",
                        "primary-container": "#008378",
                        "on-primary": "#ffffff",
                        "surface": "#f5faf8"
                    },
                    "spacing": {
                        "md": "24px",
                        "margin": "32px",
                        "xl": "64px",
                        "sm": "12px",
                        "base": "8px",
                        "lg": "48px"
                    }
                }
            }
        }
    </script>
    <style>
        html,
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            scroll-behavior: smooth;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            perspective: 1000px;
            /* Perspektif 3D global */
        }

        .medical-gradient {
            background: linear-gradient(135deg, #00685f 0%, #008378 100%);
        }

        .dark-gradient {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        section {
            content-visibility: auto;
            contain-intrinsic-size: 0 500px;
        }

        /* 3D SCROLL ANIMATION (IN & OUT EFFECT) */
        .fast-anim {
            opacity: 0;
            transform: translate3d(0, 60px, -40px) rotateX(8deg);
            will-change: transform, opacity;
            transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.8s ease;
        }

        .fast-anim.is-visible {
            opacity: 1;
            transform: translate3d(0, 0, 0) rotateX(0deg);
        }

        /* LOAD TRANSITION FOR FIXED HEADER ON REFRESH */
        .load-anim-header-3d {
            opacity: 0;
            transform: translate3d(0, -72px, 0) rotateX(-15deg);
            transform-origin: top center;
            animation: initialHeaderLoad 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes initialHeaderLoad {
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0) rotateX(0deg);
            }
        }

        /* LOAD ANIMATION FOR HERO ON REFRESH */
        .load-anim-3d {
            opacity: 0;
            transform: translate3d(0, 50px, -100px) rotateX(15deg);
            animation: initial3DLoad 1.2s cubic-bezier(0.23, 1, 0.32, 1) forwards;
            animation-delay: 0.1s;
        }

        @keyframes initial3DLoad {
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0) rotateX(0deg);
            }
        }

        /* DISEASE CARD HOLOGRAPHIC 3D TILT EFFECT */
        .disease-card-wrapper {
            perspective: 1000px;
        }

        .disease-card {
            transform-style: preserve-3d;
            transform: translate3d(0, 0, 0);
            will-change: transform;
            transition: transform 0.15s ease-out, box-shadow 0.3s ease;
        }

        .disease-card * {
            transform: translateZ(0);
        }

        .disease-card h3 {
            transition: transform 0.15s ease-out;
        }

        .disease-card:hover h3 {
            transform: translateZ(25px);
        }

        /* JavaScript Click Pulse */
        .card-clicked {
            animation: quickPulse 0.4s ease-out;
        }

        @keyframes quickPulse {
            0% {
                transform: scale3d(1, 1, 1);
            }

            50% {
                transform: scale3d(0.95, 0.95, 0.95);
            }

            100% {
                transform: scale3d(1, 1, 1);
            }
        }

        /* ELASTIC FOOTER CONTAINER */
        #footer-stretch-container {
            transform-origin: bottom center;
            will-change: transform;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
    </style>
</head>

<body class="bg-surface text-on-surface pt-[72px]">

    <!-- FIXED NAVBAR (STAY TOP - TIDAK IKUT TERSCROLL HILANG, TETAP DI ATAS DENGAN ANIMASI 3D REFRESH) -->
    <header
        class="fixed top-0 left-0 right-0 h-[75px] bg-surface/95 backdrop-blur border-b border-outline-variant shadow-sm z-50 load-anim-header-3d">
        <div class="flex justify-between items-center w-full h-full px-margin max-w-7xl mx-auto">
            <div class="flex items-center gap-md">
                <span class="text-2xl font-black text-primary tracking-tight cursor-pointer">THT-Pedia</span>
                <nav class="hidden md:flex gap-md ml-lg">
                    <a class="text-sm font-semibold text-on-surface-variant hover:text-primary transition-colors"
                        href="#hero">Beranda</a>
                    <a class="text-sm font-semibold text-on-surface-variant hover:text-primary transition-colors"
                        href="#advantages">Katalog THT</a>
                    <a class="text-sm font-semibold text-on-surface-variant hover:text-primary transition-colors"
                        href="#clinical-info">Informasi Medis</a>
                    <a class="text-sm font-semibold text-on-surface-variant hover:text-primary transition-colors"
                        href="#system-architecture">Sistem Pakar</a>
                    <a class="text-sm font-semibold text-on-surface-variant hover:text-primary transition-colors"
                        href="#features">Fitur Utama</a>
                </nav>
            </div>
            <div class="flex items-center gap-sm">
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="inline m-0">
                        @csrf
                        <button type="submit"
                            class="bg-slate-200 hover:bg-red-600 hover:text-white px-5 py-2 rounded-full text-sm font-medium transition-colors">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-primary text-on-primary px-5 py-2 rounded-full text-sm font-medium transition-all hover:opacity-90 shadow-sm">Masuk</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-margin py-md">

        <!-- SECTION 1: HERO BANNER (3D Load Anim on Refresh) -->
        <section id="hero"
            class="relative overflow-hidden rounded-3xl medical-gradient p-lg mb-xl shadow-xl text-white load-anim-3d">
            <div class="grid md:grid-cols-2 gap-lg items-center relative z-10">
                <div class="space-y-md">
                    <span
                        class="bg-white/20 text-white font-bold text-xs px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-sm inline-block">Sistem
                        Pakar Terakreditasi</span>
                    <h1 class="text-4xl md:text-6xl font-black tracking-tight leading-none">Portal Klinis Kesehatan THT
                    </h1>
                    <p class="text-lg opacity-90 leading-relaxed max-w-lg">
                        Identifikasi patologi Telinga, Hidung, dan Tenggorokan secara dini menggunakan mesin komputasi
                        Certainty Factor terstandarisasi.
                    </p>
                    <div class="flex flex-wrap gap-4 pt-2">
                        <a href="#features"
                            class="bg-white text-primary font-bold px-7 py-3.5 rounded-xl shadow-md transition-transform active:scale-95">Mulai
                            Tes Kesehatan</a>
                        <a href="#advantages"
                            class="border border-white/30 text-white font-semibold px-7 py-3.5 rounded-xl hover:bg-white/10 transition-colors">Pelajari
                            5 Penyakit</a>
                    </div>
                </div>
                <div class="hidden md:block text-center">
                    <img alt="Tenaga Medis"
                        class="w-full max-w-sm mx-auto h-auto object-cover rounded-2xl shadow-2xl border border-white/20"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuC2J9Jc2n4lSJ4K1D3CS4LIEkycPzZUo0_N7mUmWGt_WAgNSpT1YnC7IOYaRmu0reNxEPx_tHXpihaj4nBNGh5UbKateZJtm6VFJ9p1AYl8ERMS2hIZHigUGA3xQQ-OnIgLrWq8tcmRQZRPZ3a2OHoWqGxY0Ogpwj0njHq9VqN3qtNI2xxKq73BBUhCuwrY4d_l5UK8nn2lvTyu8myZIneKza-ve7TNwVMmbIwMAnEBqO866C4uNuEXP4VDVUVhOYg6aq1BaVw1Sw" />
                </div>
            </div>
        </section>

        <!-- SECTION 2: SLIDER PENYAKIT (Scroll In-Out Anim) -->
        <section id="advantages" class="mb-xl px-2 fast-anim">
            <div class="flex justify-between items-end mb-6">
                <div>
                    <span class="text-primary font-bold text-xs uppercase tracking-widest block">Ensiklopedia
                        Penyakit</span>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Katalog Data Patologi Utama (5
                        Penyakit)</h2>
                </div>
                <div class="flex gap-2">
                    <button onclick="scrollGrid(-320)"
                        class="w-10 h-10 rounded-full border border-slate-300 bg-white text-slate-700 flex items-center justify-center hover:bg-primary hover:text-white transition-colors shadow-sm"><span
                            class="material-symbols-outlined">arrow_back</span></button>
                    <button onclick="scrollGrid(320)"
                        class="w-10 h-10 rounded-full border border-slate-300 bg-white text-slate-700 flex items-center justify-center hover:bg-primary hover:text-white transition-colors shadow-sm"><span
                            class="material-symbols-outlined">arrow_forward</span></button>
                </div>
            </div>

            <div id="disease-scroll-container"
                class="flex gap-md overflow-x-auto pb-6 pt-2 no-scrollbar snap-x snap-mandatory scroll-smooth disease-card-wrapper">
                <!-- 1. OMA -->
                <div onclick="animateCardClick(this)"
                    class="disease-card flex-none w-[290px] sm:w-[320px] bg-white border border-outline-variant rounded-2xl overflow-hidden shadow-sm snap-start cursor-pointer">
                    <div class="h-44 relative overflow-hidden bg-slate-100">
                        <img class="w-full h-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDycQvDxtF2j7u-L9I44yhstCvhmsrNS9MGIs62hyo95z183Uxu_EurcnTq0q-GTTDlSmoE_1TAn9xYEKPuj1fg1VW4FKluUtkx3PGjWmfRVvwE9nLckKbvUH3NlWpOL844EYbcMduD1sp_e9ezddySrBscdpuECb9OfhHGIRWW8ob9Y5nyz7QiyBGuDKJHHXsAgum52B_IdP439qtf-sKQ0gyLa_wevDqYkonyiqCUtimK8avqw4w_yRhl_7KW-s-TEuxB-HXodA"
                            alt="OMA" loading="lazy" />
                        <span
                            class="absolute top-3 left-3 bg-primary text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">KODE:
                            P001</span>
                    </div>
                    <div class="p-5 space-y-2">
                        <h3 class="font-bold text-lg text-slate-800">Otitis Media Akut (OMA)</h3>
                        <p class="text-xs text-on-surface-variant leading-relaxed line-clamp-4">Infeksi mendadak pada
                            telinga tengah disertai penumpukan cairan efusi, inflamasi membran timpani, serta memicu
                            otalgia hebat.</p>
                    </div>
                </div>
                <!-- 2. Serumen -->
                <div onclick="animateCardClick(this)"
                    class="disease-card flex-none w-[290px] sm:w-[320px] bg-white border border-outline-variant rounded-2xl overflow-hidden shadow-sm snap-start cursor-pointer">
                    <div class="h-44 relative overflow-hidden bg-slate-100">
                        <img class="w-full h-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCpHVUgIKGmTNV-ykI1bvuRRKH_18NXL9zjrZ8L3PjZQji8ItEFGreuOt8hAIaPDXH2HGIB6n8OvrdEj8EYfpJGh2n1-KgEL17Kq-QQnakn72iGjPcixiSwpbCrZSB8LERBhM8GXjox8Vq9MizhdNN-SK1r3TEiUnXEFw0g6FFn0206sRMK1Tv_u1ai777Ctn9FqhVEJzYGb27VBG_7168HHsOn4fQpM1dyRlajGcpTAp-mGmYNj8hE5OoDtJapUNhonFuOGyEmfg"
                            alt="Serumen" loading="lazy" />
                        <span
                            class="absolute top-3 left-3 bg-slate-700 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">KODE:
                            P002</span>
                    </div>
                    <div class="p-5 space-y-2">
                        <h3 class="font-bold text-lg text-slate-800">Serumen (Kotoran Telinga)</h3>
                        <p class="text-xs text-on-surface-variant leading-relaxed line-clamp-4">Akumulasi serumen yang
                            mengeras dan menyumbat total kanalis akustikus eksternus, memicu gangguan pendengaran
                            konduktif.</p>
                    </div>
                </div>
                <!-- 3. OE -->
                <div onclick="animateCardClick(this)"
                    class="disease-card flex-none w-[290px] sm:w-[320px] bg-white border border-outline-variant rounded-2xl overflow-hidden shadow-sm snap-start cursor-pointer">
                    <div class="h-44 relative overflow-hidden bg-slate-100">
                        <img class="w-full h-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBt6psc7P-xgfIW9DfKsaWGpxfYJApMKihX5WX31TOjeNRJNF5IGd1qXCZlLUaN2bAFng42_dUcJXo-SDN7unMxLb4dyIrcBwyvdKyEfq0Fdj7lsmj1YoZbjIkNPMzUItrfv1W8NXSK8M9boCK82vGMypNzLM7dFWGThajedai2OsiE3SbZMUREEV9k0im-hvHS0CSxZvdStvE5XvkgRd5uyAH6_OH04BYTEM-Rfg7hS6BjQh_0qtuyT8L17lDDJ22DlJJLWxJuiA"
                            alt="OE" loading="lazy" />
                        <span
                            class="absolute top-3 left-3 bg-amber-700 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">KODE:
                            P003</span>
                    </div>
                    <div class="p-5 space-y-2">
                        <h3 class="font-bold text-lg text-slate-800">Otitis Eksterna (OE)</h3>
                        <p class="text-xs text-on-surface-variant leading-relaxed line-clamp-4">Inflamasi saluran
                            telinga luar akibat maserasi kulit karena kelembapan, ditandai nyeri saat tragus telinga
                            ditekan.</p>
                    </div>
                </div>
                <!-- 4. Sinusitis -->
                <div onclick="animateCardClick(this)"
                    class="disease-card flex-none w-[290px] sm:w-[320px] bg-white border border-outline-variant rounded-2xl overflow-hidden shadow-sm snap-start cursor-pointer">
                    <div class="h-44 relative overflow-hidden bg-slate-100">
                        <img class="w-full h-full object-cover"
                            src="https://images.unsplash.com/photo-1628771065518-0d82f1938462?auto=format&fit=crop&w=500&q=80"
                            alt="Sinusitis" loading="lazy" />
                        <span
                            class="absolute top-3 left-3 bg-rose-700 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">KODE:
                            P004</span>
                    </div>
                    <div class="p-5 space-y-2">
                        <h3 class="font-bold text-lg text-slate-800">Sinusitis</h3>
                        <p class="text-xs text-on-surface-variant leading-relaxed line-clamp-4">Peradangan mukosa
                            rongga sinus paranasal, memicu hidung tersumbat kronis, nyeri tekan daerah wajah, serta
                            sakit kepala.</p>
                    </div>
                </div>
                <!-- 5. Rhinitis -->
                <div onclick="animateCardClick(this)"
                    class="disease-card flex-none w-[290px] sm:w-[320px] bg-white border border-outline-variant rounded-2xl overflow-hidden shadow-sm snap-start cursor-pointer">
                    <div class="h-44 relative overflow-hidden bg-slate-100">
                        <img class="w-full h-full object-cover"
                            src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=500&q=80"
                            alt="Rhinitis" loading="lazy" />
                        <span
                            class="absolute top-3 left-3 bg-indigo-700 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">KODE:
                            P005</span>
                    </div>
                    <div class="p-5 space-y-2">
                        <h3 class="font-bold text-lg text-slate-800">Rhinitis Kronis</h3>
                        <p class="text-xs text-on-surface-variant leading-relaxed line-clamp-4">Inflamasi persisten
                            pada lapisan mukosa hidung (>12 minggu), menyebabkan rinore (lendir kental) dan bersin
                            berulang.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 3: EDUKASI MEDIS (Scroll In-Out Anim) -->
        <section id="clinical-info" class="border-t border-outline-variant py-xl space-y-xl">
            <div class="grid md:grid-cols-2 gap-lg items-center fast-anim">
                <div class="space-y-4">
                    <span
                        class="text-primary font-bold text-xs uppercase bg-primary/10 px-3 py-1 rounded-full inline-block">Patofisiologi
                        Sistem</span>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight">Pentingnya Diagnosis Dini Organ THT
                    </h3>
                    <p class="text-sm text-on-surface-variant leading-relaxed">
                        Telinga, hidung, dan tenggorokan terhubung melalui saluran khusus bernama <strong>Tuba
                            Eustachius</strong>. Infeksi yang tidak ditangani pada area hidung dapat menyebar dengan
                        mudah ke telinga tengah.
                    </p>
                </div>
                <div class="relative overflow-hidden rounded-2xl shadow-md border border-slate-200 bg-slate-100">
                    <img class="w-full h-64 md:h-80 object-cover"
                        src="https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=800&q=80"
                        alt="Pemeriksaan" loading="lazy" />
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-lg items-center fast-anim">
                <div
                    class="order-2 md:order-1 relative overflow-hidden rounded-2xl shadow-md border border-slate-200 bg-slate-100">
                    <img class="w-full h-64 md:h-80 object-cover"
                        src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800&q=80"
                        alt="Analisis" loading="lazy" />
                </div>
                <div class="space-y-4 order-1 md:order-2">
                    <span
                        class="text-amber-700 font-bold text-xs uppercase bg-amber-50 px-3 py-1 rounded-full inline-block">Metodologi
                        Certainty Factor</span>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight">Kalkulasi Bobot Gejala Berbasis Pakar
                    </h3>
                    <p class="text-sm text-on-surface-variant leading-relaxed">
                        Setiap gejala yang Anda pilih memiliki nilai keyakinan yang bersumber dari dokter spesialis THT
                        untuk membuahkan hasil diagnosis diferensial peringkat teratas.
                    </p>
                </div>
            </div>
        </section>

        <!-- SECTION 4: STRUKTUR DATA (Scroll In-Out Anim) -->
        <section id="system-architecture" class="border-t border-outline-variant py-xl space-y-lg fast-anim">
            <div class="text-center max-w-3xl mx-auto space-y-2">
                <span class="text-primary font-bold text-xs uppercase tracking-widest block">Struktur Data
                    Pengetahuan</span>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Mekanisme Mesin Inferensi &amp; Aturan
                    Medis</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-md">
                <div class="p-6 bg-white border border-outline-variant rounded-2xl space-y-3 shadow-sm">
                    <div
                        class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                        01</div>
                    <h4 class="font-bold text-base text-slate-900">Akuisisi Gejala (Evidence)</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Pasien memilih manifestasi klinis yang
                        dirasakan. Setiap opsi terikat dengan nilai keyakinan pengguna.</p>
                </div>
                <div class="p-6 bg-white border border-outline-variant rounded-2xl space-y-3 shadow-sm">
                    <div
                        class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                        02</div>
                    <h4 class="font-bold text-base text-slate-900">Kombinasi Rule Pakar</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Mesin mengalikan bobot dokter dengan
                        bobot pasien menggunakan rumus matriks komputasi probabilitas.</p>
                </div>
                <div class="p-6 bg-white border border-outline-variant rounded-2xl space-y-3 shadow-sm">
                    <div
                        class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                        03</div>
                    <h4 class="font-bold text-base text-slate-900">Hasil Prediksi Final</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed">Nilai akhir dipersentasekan untuk
                        memunculkan patologi dengan tingkat keyakinan tertinggi.</p>
                </div>
            </div>

            <div class="bg-white border border-outline-variant rounded-2xl overflow-hidden shadow-sm mt-md">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-100 text-slate-700 font-semibold border-b border-outline-variant">
                                <th class="p-4">Kode</th>
                                <th class="p-4">Gejala Spesifik Patologi</th>
                                <th class="p-4">Korelasi Utama Penyakit</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-on-surface-variant">
                            <tr>
                                <td class="p-4 font-mono font-bold text-primary">G001</td>
                                <td class="p-4">Nyeri hebat mendadak di dalam telinga (Otalgia)</td>
                                <td class="p-4">Otitis Media Akut</td>
                            </tr>
                            <tr>
                                <td class="p-4 font-mono font-bold text-primary">G002</td>
                                <td class="p-4">Rasa penuh di liang telinga</td>
                                <td class="p-4">Serumen Prop</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- SECTION 5: DASHBOARD INFO (Scroll In-Out Anim) -->
        <section id="features" class="dark-gradient text-white rounded-3xl p-md md:p-lg shadow-xl fast-anim">
            <div class="grid md:grid-cols-3 gap-md">
                <div class="p-5 bg-slate-800/80 border border-slate-700 rounded-2xl">
                    <span class="material-symbols-outlined text-3xl text-primary mb-2 block">schema</span>
                    <h4 class="font-bold text-sm mb-1">Certainty Factor Teruji</h4>
                    <p class="text-xs text-slate-400">Perhitungan otomatis kepastian penyakit berdasarkan akumulasi
                        gejala klinis pasien.</p>
                </div>
                <div class="p-5 bg-slate-800/80 border border-slate-700 rounded-2xl">
                    <span class="material-symbols-outlined text-3xl text-primary mb-2 block">history</span>
                    <h4 class="font-bold text-sm mb-1">Riwayat Diagnosis</h4>
                    <p class="text-xs text-slate-400">Menyimpan dan memantau perkembangan fluktuasi skor kepastian
                        hasil secara berkala.</p>
                </div>
                <div class="p-5 bg-slate-800/80 border border-slate-700 rounded-2xl">
                    <span class="material-symbols-outlined text-3xl text-primary mb-2 block">print</span>
                    <h4 class="font-bold text-sm mb-1">Ekspor PDF Rujukan</h4>
                    <p class="text-xs text-slate-400">Mencetak hasil komprehensif peringkat diagnosis penyakit menjadi
                        berkas cetak siap pakai.</p>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER WRAPPER FOR ELASTIC EFFECT -->
    <div id="footer-stretch-container">
        <footer class="bg-inverse-surface text-inverse-on-surface py-xl border-t border-slate-800 mt-xl">
            <div class="max-w-7xl mx-auto px-margin text-center text-xs opacity-50">
                <p>&copy; {{ date('Y') }} Sistem Informasi Klinis THT-Pedia. Hak Cipta Dilindungi Sepenuhnya.</p>
            </div>
        </footer>
    </div>

    <!-- ADVANCED ANIMATION & INTERACTION ENGINE -->
    <script>
        // 1. DUAL DIRECTION SCROLL ANIMATION (IN & OUT)
        const observerOptions = {
            root: null,
            rootMargin: '-40px 0px -40px 0px',
            threshold: 0.1
        };

        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                } else {
                    entry.target.classList.remove('is-visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fast-anim').forEach(el => io.observe(el));


        // 2. ULTRA-SMOOTH 3D MOUSE TILT EFFECT FOR CARDS
        const cards = document.querySelectorAll('.disease-card');
        cards.forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const centerX = rect.width / 2;
                const centerY = rect.height / 2;

                const rotateX = ((centerY - y) / centerY) * 15;
                const rotateY = ((x - centerX) / centerX) * 15;

                card.style.transform =
                    `translate3d(0, -8px, 20px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                card.style.boxShadow =
                    `${-rotateY * 2}px ${rotateX * 2 + 20}px 35px -10px rgba(0, 104, 95, 0.3)`;
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translate3d(0, 0, 0) rotateX(0deg) rotateY(0deg)';
                card.style.boxShadow = '0 1px 3px 0 rgba(0,0,0,0.1)';
            });
        });


        // 3. ELASTIC / RUBBER-BAND FOOTER STRETCH REPAIR
        const footerContainer = document.getElementById('footer-stretch-container');
        let startY = 0;
        let isAtBottom = false;

        window.addEventListener('touchstart', (e) => {
            isAtBottom = (window.innerHeight + window.scrollY) >= document.documentElement.scrollHeight - 2;
            startY = e.touches[0].pageY;
        }, {
            passive: true
        });

        window.addEventListener('touchmove', (e) => {
            if (!isAtBottom) return;

            const currentY = e.touches[0].pageY;
            const diff = startY - currentY;

            if (diff > 0) {
                const stretchFactor = 1 + Math.min(diff / 500, 0.25);
                footerContainer.style.transform = `scaleY(${stretchFactor})`;
            }
        }, {
            passive: true
        });

        window.addEventListener('touchend', () => {
            footerContainer.style.transform = 'scaleY(1)';
        });

        window.addEventListener('scroll', () => {
            const scrollBottom = document.documentElement.scrollHeight - window.innerHeight - window.scrollY;
            if (scrollBottom < 0) {
                const stretch = 1 + (Math.abs(scrollBottom) / 200);
                footerContainer.style.transform = `scaleY(${stretch})`;
            } else {
                footerContainer.style.transform = 'scaleY(1)';
            }
        });


        // Horizontal scroll utility
        function scrollGrid(direction) {
            document.getElementById('disease-scroll-container').scrollBy({
                left: direction,
                behavior: 'smooth'
            });
        }

        // Quick click response
        function animateCardClick(element) {
            element.classList.remove('card-clicked');
            void element.offsetWidth;
            element.classList.add('card-clicked');
        }
    </script>
</body>

</html>
