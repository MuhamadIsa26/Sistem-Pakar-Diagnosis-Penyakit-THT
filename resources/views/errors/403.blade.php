<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Terbatas | THT-Pedia</title>

    <!-- Tailwind CSS Engine -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="h-full bg-slate-50 flex items-center justify-center p-4 antialiased">

    <!-- Container Utama Card Eror -->
    <div
        class="max-w-md w-full bg-white border border-slate-200 rounded-2xl p-8 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">

        <!-- Ornamen Aksen Dekoratif Atas -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-[#00685f]"></div>

        <!-- Ilustrasi Emblem Keamanan Medis -->
        <div
            class="mb-6 inline-flex items-center justify-center w-20 h-20 bg-rose-50 rounded-full border border-rose-100 text-rose-600 relative">
            <span class="material-symbols-outlined text-4xl font-bold animate-pulse">enhanced_encryption</span>
            <!-- Badge Angka Kode Eror Kecil -->
            <span
                class="absolute -bottom-1 -right-1 bg-slate-900 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full border-2 border-white font-mono">
                403
            </span>
        </div>

        <!-- Judul Status Eror -->
        <h1 class="text-xl font-black text-slate-900 tracking-tight mb-2">
            Akses Ditolak Sistem
        </h1>

        <!-- Deskripsi Pesan Eror Dinamis Bawaan Middleware -->
        <p class="text-xs text-slate-600 font-medium leading-relaxed px-2 mb-8">
            {{ $exception->getMessage() ?: 'Akses tidak sah. Halaman ini dilindungi dan hanya boleh diakses oleh Admin Pakar.' }}
        </p>

        <!-- Garis Pembatas Halus -->
        <div class="w-full h-px bg-slate-100 mb-6"></div>

        <!-- Tombol Aksi Navigasi Penyelamat -->
        <div class="flex flex-col sm:flex-row gap-2 justify-center items-center">
            <a href="javascript:history.back()"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all active:scale-95 cursor-pointer">
                <span class="material-symbols-outlined text-base font-bold">arrow_back</span>
                Kembali
            </a>
            <a href="{{ url('/') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-5 py-2.5 bg-[#00685f] hover:bg-[#008378] text-white text-xs font-bold rounded-xl transition-all shadow-sm active:scale-95 cursor-pointer">
                <span class="material-symbols-outlined text-base font-bold">home</span>
                Ke Halaman Utama
            </a>
        </div>

        <!-- Footer Identitas Aplikasi -->
        <div
            class="mt-8 flex items-center justify-center gap-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
            <span class="material-symbols-outlined text-xs">medical_services</span>
            THT-Pedia Diagnostic System
        </div>
    </div>

</body>

</html>
