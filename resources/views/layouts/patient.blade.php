<!DOCTYPE html>
<html lang="id" class="overscroll-none scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Dashboard Pasien') - Sistem Pakar THT</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..24,400..700,0..1,0" />

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body
    class="bg-[#f5faf8] min-h-screen text-slate-800 flex flex-col overscroll-none w-full overflow-x-hidden antialiased">

    <!-- 1. Navigasi Global Pasien -->
    <nav class="bg-white border-b border-[#bcc9c6] sticky top-0 z-50 shadow-sm print:hidden w-full flex-shrink-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">

            <!-- Kiri: Logo & Menu Desktop -->
            <div class="flex items-center gap-8">
                <a href="{{ route('patient.home') }}"
                    class="flex items-center gap-2 text-[#00685f] transition-opacity hover:opacity-90">
                    <span class="material-symbols-outlined font-bold text-2xl">medical_information</span>
                    <span class="font-bold text-base tracking-tight">THT-Pedia</span>
                </a>

                <!-- Navigasi Utama: Khusus Desktop (md ke atas) -->
                <div class="hidden md:flex items-center gap-6">
                    <a class="text-xs font-bold uppercase tracking-wider pb-1 transition-all {{ request()->routeIs('patient.home') ? 'text-[#00685f] border-b-2 border-[#00685f]' : 'text-slate-400 hover:text-[#00685f]' }}"
                        href="{{ route('patient.home') }}">Home & About</a>

                    <a class="text-xs font-bold uppercase tracking-wider pb-1 transition-all {{ request()->routeIs('patient.diagnosis.*') ? 'text-[#00685f] border-b-2 border-[#00685f]' : 'text-slate-400 hover:text-[#00685f]' }}"
                        href="{{ route('patient.diagnosis.questionnaire') }}">Form Diagnosis</a>

                    <a class="text-xs font-bold uppercase tracking-wider pb-1 transition-all {{ request()->routeIs('patient.history') ? 'text-[#00685f] border-b-2 border-[#00685f]' : 'text-slate-400 hover:text-[#00685f]' }}"
                        href="{{ route('patient.history') }}">Riwayat Medis</a>
                </div>
            </div>

            <!-- Kanan: Info User & Tombol Hamburger Mobile -->
            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Status Halaman -->
                @if (request()->routeIs('patient.diagnosis.*'))
                    <span
                        class="hidden sm:inline-block text-[10px] font-black uppercase tracking-widest px-2.5 py-1.5 bg-[#00685f]/10 text-[#00685f] rounded-lg border border-[#00685f]/20">Diagnosa</span>
                @elseif(request()->routeIs('patient.history'))
                    <span
                        class="hidden sm:inline-block text-[10px] font-black uppercase tracking-widest px-2.5 py-1.5 bg-slate-100 text-slate-500 rounded-lg border border-slate-200">Riwayat</span>
                @elseif(request()->routeIs('patient.home'))
                    <span
                        class="hidden sm:inline-block text-[10px] font-black uppercase tracking-widest px-2.5 py-1.5 bg-emerald-50 text-[#00685f] rounded-lg border border-emerald-200">Dashboard</span>
                @endif

                <!-- Nama User -->
                <span
                    class="text-xs font-bold text-[#3d4947] bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-200 max-w-[100px] sm:max-w-[160px] truncate">
                    {{ auth()->user()->nama ?? auth()->user()->name }}
                </span>

                <!-- Tombol Keluar Desktop -->
                <form action="{{ route('logout') }}" method="POST" class="hidden sm:inline m-0">
                    @csrf
                    <button type="submit"
                        class="text-xs text-rose-600 font-bold flex items-center gap-1 hover:text-rose-700 cursor-pointer transition-colors">
                        <span class="material-symbols-outlined text-xs">logout</span> Keluar
                    </button>
                </form>

                <!-- Tombol Hamburger Mobile -->
                <button id="mobile-menu-btn"
                    class="md:hidden flex items-center justify-center p-1.5 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-2xl" id="menu-icon">menu</span>
                </button>
            </div>
        </div>

        <!-- Menu Dropdown Mobile -->
        <div id="mobile-menu"
            class="hidden md:hidden border-t border-slate-100 bg-white px-4 py-3 shadow-inner flex flex-col gap-2 transition-all">
            <a class="block px-3 py-2 text-sm font-semibold rounded-lg {{ request()->routeIs('patient.home') ? 'bg-[#00685f]/10 text-[#00685f]' : 'text-slate-600 hover:bg-slate-50' }}"
                href="{{ route('patient.home') }}">Home & About</a>
            <a class="block px-3 py-2 text-sm font-semibold rounded-lg {{ request()->routeIs('patient.diagnosis.*') ? 'bg-[#00685f]/10 text-[#00685f]' : 'text-slate-600 hover:bg-slate-50' }}"
                href="{{ route('patient.diagnosis.questionnaire') }}">Form Diagnosis</a>
            <a class="block px-3 py-2 text-sm font-semibold rounded-lg {{ request()->routeIs('patient.history') ? 'bg-[#00685f]/10 text-[#00685f]' : 'text-slate-600 hover:bg-slate-50' }}"
                href="{{ route('patient.history') }}">Riwayat Medis</a>
            <hr class="border-slate-100 my-1">
            <form action="{{ route('logout') }}" method="POST" class="block w-full m-0">
                @csrf
                <button type="submit"
                    class="w-full text-left px-3 py-2 text-sm font-bold text-rose-600 hover:bg-rose-50 rounded-lg flex items-center gap-2 cursor-pointer">
                    <span class="material-symbols-outlined text-sm">logout</span> Keluar Akun
                </button>
            </form>
        </div>
    </nav>

    <!-- 2. Konten Utama -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10 box-border">
        @yield('content')
    </main>

    <!-- 3. Footer Global -->
    <footer class="bg-white border-t border-[#bcc9c6] py-6 w-full flex-shrink-0 print:hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-xs text-[#3d4947] font-medium tracking-wide">
                &copy; {{ date('Y') }} THT-Pedia Expert Medical Systems.
            </p>
        </div>
    </footer>

    <!-- Script Dropdown Mobile -->
    <script>
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            if (mobileMenu.classList.contains('hidden')) {
                menuIcon.textContent = 'menu';
            } else {
                menuIcon.textContent = 'close';
            }
        });
    </script>
</body>

</html>
