<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pakar THT</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Google Material Symbols -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 sm:p-6 md:p-8">

    <!-- Card Container: Mobile-first responsive widths and padding -->
    <div
        class="bg-white w-full max-w-md p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-xl transition-all duration-300">
        <!-- Logo & Header -->
        <div class="text-center mb-6 sm:mb-8">
            <div class="inline-flex p-3 bg-[#00685f]/10 text-[#00685f] rounded-full mb-3">
                <span class="material-symbols-outlined text-2xl sm:text-3xl font-bold">medical_information</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-bold text-[#171d1c] tracking-tight">Selamat Datang Kembali</h2>
            <p class="text-xs sm:text-sm text-[#3d4947] mt-1.5 px-2">Silakan masuk untuk mengakses dasbor sistem pakar.
            </p>
        </div>

        <!-- Notifikasi Alert Gagal -->
        @if (session('error'))
            <div
                class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-5 text-xs sm:text-sm flex items-center gap-2 font-medium">
                <span class="material-symbols-outlined text-lg shrink-0">error</span>
                <span class="break-words">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Notifikasi Alert Sukses Registrasi -->
        @if (session('success'))
            <div
                class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl mb-5 text-xs sm:text-sm flex items-center gap-2 font-medium">
                <span class="material-symbols-outlined text-lg text-emerald-600 shrink-0">check_circle</span>
                <span class="break-words">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Form Login -->
        <form action="{{ route('login') }}" method="POST" class="space-y-4 sm:space-y-5">
            @csrf

            <div>
                <label class="block text-slate-700 text-xs sm:text-sm font-semibold mb-1.5">Username Anda</label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base sm:text-lg">person</span>
                    <!-- Minimum height 44px for touch targets on mobile -->
                    <input type="text" name="username" value="{{ old('username') }}"
                        placeholder="Masukkan username..."
                        class="w-full pl-11 pr-4 py-2.5 sm:py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00685f]/50 text-xs sm:text-sm text-slate-800 transition-all min-h-[44px] @error('username') border-red-500 @enderror"
                        required autocomplete="username" autofocus>
                </div>
                @error('username')
                    <p class="text-red-500 text-[11px] sm:text-xs mt-1.5 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-slate-700 text-xs sm:text-sm font-semibold mb-1.5">Kata Sandi</label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base sm:text-lg">lock</span>
                    <!-- Minimum height 44px for touch targets on mobile -->
                    <input type="password" name="password" placeholder="••••••••"
                        class="w-full pl-11 pr-4 py-2.5 sm:py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00685f]/50 text-xs sm:text-sm text-slate-800 transition-all min-h-[44px]"
                        required>
                </div>
            </div>

            <!-- Responsive Layout for Checkbox & Password Reset Links -->
            <div
                class="flex flex-row items-center justify-between text-[11px] sm:text-xs font-semibold text-[#3d4947] pt-1">
                <label class="flex items-center gap-2 cursor-pointer select-none min-h-[32px]">
                    <input type="checkbox" name="remember" class="accent-[#00685f] rounded w-3.5 h-3.5 sm:w-4 sm:h-4">
                    Ingat Saya
                </label>
                <a href="{{ route('password.request') }}"
                    class="text-[#00685f] hover:underline min-h-[32px] flex items-center">
                    Lupa Kata Sandi?
                </a>
            </div>

            <!-- Minimum height 44px button with active tap micro-interactions -->
            <button type="submit"
                class="w-full py-3 bg-[#00685f] text-white font-bold text-xs sm:text-sm rounded-xl hover:bg-[#00574f] transition-all shadow-sm cursor-pointer active:scale-[0.98] min-h-[44px]">
                Masuk ke Akun
            </button>
        </form>

        <!-- Link ke Registrasi -->
        <div class="text-center mt-6 pt-5 border-t border-slate-100">
            <p class="text-[11px] sm:text-xs text-[#3d4947] font-medium leading-relaxed">
                Belum punya akun rekam medis?
                <a href="{{ route('register') }}"
                    class="text-[#00685f] font-bold hover:underline block sm:inline-block mt-1 sm:mt-0 sm:ml-1">
                    Daftar Sekarang
                </a>
            </p>
        </div>
    </div>

</body>

</html>
