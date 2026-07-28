<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - THT-Pedia</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            background-color: #f5faf8;
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-[#f5faf8] text-[#171d1c] antialiased">

    <!-- 1. SIDEBAR NAVIGATION -->
    <aside
        class="h-screen w-64 fixed left-0 top-0 z-50 bg-[#f0f5f2] border-r border-[#bcc9c6] flex flex-col py-8 px-3 space-y-1">
        <div class="px-6 mb-12">
            <h1 class="text-xl font-bold tracking-wide text-[#00685f]">THT-Pedia</h1>
            <p class="text-xs text-[#3d4947]">Medical System Admin</p>
        </div>

        <nav class="flex-1 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 rounded-lg px-6 py-3 font-semibold text-sm transition-all ease-out duration-150 active:scale-100 scale-95 
                {{ Request::is('admin/dashboard') ? 'bg-[#008378] text-[#f4fffc]' : 'text-[#3d4947] hover:bg-[#dce0e4]' }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.symptoms.index') }}"
                class="flex items-center gap-3 rounded-lg px-6 py-3 font-semibold text-sm transition-all ease-out duration-150 active:scale-100 scale-95 
                {{ Request::is('admin/symptoms*') ? 'bg-[#008378] text-[#f4fffc]' : 'text-[#3d4947] hover:bg-[#dce0e4]' }}">
                <span class="material-symbols-outlined">medical_services</span>
                <span>Symptoms</span>
            </a>

            <a href="{{ route('admin.diseases.index') }}"
                class="flex items-center gap-3 rounded-lg px-6 py-3 font-semibold text-sm transition-all ease-out duration-150 active:scale-100 scale-95 
                {{ Request::is('admin/diseases*') ? 'bg-[#008378] text-[#f4fffc]' : 'text-[#3d4947] hover:bg-[#dce0e4]' }}">
                <span class="material-symbols-outlined">folder_special</span>
                <span>Diseases</span>
            </a>

            <a href="{{ route('admin.rules.index') }}"
                class="flex items-center gap-3 rounded-lg px-6 py-3 font-semibold text-sm transition-all ease-out duration-150 active:scale-100 scale-95 
                {{ Request::is('admin/rules*') ? 'bg-[#008378] text-[#f4fffc]' : 'text-[#3d4947] hover:bg-[#dce0e4]' }}">
                <span class="material-symbols-outlined">storage</span>
                <span>Knowledge Base</span>
            </a>

            <!-- PERBAIKAN: Penambahan Menu Riwayat Diagnosis (History Log) secara Utuh -->
            <a href="{{ route('admin.history.index') }}"
                class="flex items-center gap-3 rounded-lg px-6 py-3 font-semibold text-sm transition-all ease-out duration-150 active:scale-100 scale-95 
                {{ Request::is('admin/history*') ? 'bg-[#008378] text-[#f4fffc]' : 'text-[#3d4947] hover:bg-[#dce0e4]' }}">
                <span class="material-symbols-outlined">history</span>
                <span>History Log</span>
            </a>
        </nav>

        <div class="px-3 mt-auto pt-6 border-t border-[#bcc9c6]/40">
            <div class="flex items-center gap-3 p-3 bg-[#dee4e1] rounded-xl overflow-hidden shadow-sm">
                <div
                    class="w-10 h-10 rounded-full bg-[#00685f] text-[#ffffff] flex items-center justify-center font-bold text-sm shrink-0 border-2 border-[#00685f]/20">
                    {{ strtoupper(substr(auth()->user()->username ?? 'A', 0, 1)) }}
                </div>
                <div class="overflow-hidden flex-1">
                    <p class="text-xs font-bold text-[#171d1c] truncate">{{ auth()->user()->username ?? 'Admin User' }}
                    </p>
                    <p class="text-[10px] text-[#3d4947] truncate">Administrator</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- RIGHT MAIN CANVAS WRAPPER -->
    <div class="ml-64 flex flex-col min-h-screen">

        <!-- 2. TOP NAVBAR -->
        <header
            class="flex justify-between items-center w-full px-8 h-16 fixed top-0 right-0 z-40 bg-[#f5faf8] border-b border-[#bcc9c6] shadow-sm max-w-[calc(100%-16rem)]">
            <div class="flex items-center">
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#6d7a77] pointer-events-none">
                        <span class="material-symbols-outlined text-xl">search</span>
                    </span>
                    <input type="text" placeholder="Cari data atau basis aturan..."
                        class="bg-[#eaefed] border-none rounded-full py-1.5 pl-10 pr-6 text-sm w-64 focus:ring-2 focus:ring-[#00685f] focus:outline-none transition-all duration-200 placeholder-[#6d7a77] text-[#171d1c]" />
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button
                    class="p-1.5 rounded-full hover:bg-[#eaefed] transition-colors text-[#00685f] relative cursor-pointer">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-[#ba1a1a] rounded-full"></span>
                </button>
                <button class="p-1.5 rounded-full hover:bg-[#eaefed] transition-colors text-[#00685f] cursor-pointer">
                    <span class="material-symbols-outlined">help</span>
                </button>

                <span class="w-px h-6 bg-[#bcc9c6]"></span>

                <form action="{{ route('logout') }}" method="POST" class="inline m-0">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-1.5 text-xs bg-[#eaefed] hover:bg-red-50 text-[#3d4947] hover:text-red-600 px-3.5 py-2 border border-[#bcc9c6] rounded-lg transition-all font-semibold cursor-pointer shadow-sm">
                        <span class="material-symbols-outlined text-sm">logout</span>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- 3. MAIN CONTENT CANVAS -->
        <main class="flex-1 p-8 mt-16 max-w-[1440px] w-full mx-auto">
            @yield('content')
        </main>
    </div>

    @include('admin.symptom_add')

</body>

</html>
