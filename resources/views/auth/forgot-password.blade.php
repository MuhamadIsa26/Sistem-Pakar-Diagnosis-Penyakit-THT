<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemulihan Kata Sandi - Sistem Pakar THT</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Google Material Symbols -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 sm:p-6 md:p-8">

    <!-- Card Container: Mobile-first dynamic layout structure -->
    <div
        class="bg-white w-full max-w-md p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-xl transition-all duration-300">
        <!-- Header -->
        <div class="text-center mb-6">
            <div class="inline-flex p-3 bg-[#00685f]/10 text-[#00685f] rounded-full mb-3">
                <span class="material-symbols-outlined text-2xl sm:text-3xl font-bold">lock_reset</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-bold text-[#171d1c] tracking-tight">Lupa Kata Sandi</h2>
            <p class="text-xs sm:text-sm text-[#3d4947] mt-1.5 px-2">Masukkan username Akun Anda untuk memperbarui kata
                sandi rekam medis secara mandiri.</p>
        </div>

        <!-- Form Pemulihan -->
        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-slate-700 text-xs sm:text-sm font-semibold mb-1.5">Username Akun Anda</label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base sm:text-lg">person</span>
                    <!-- Min-height 44px for touch targets on mobile -->
                    <input type="text" name="username" value="{{ old('username') }}"
                        placeholder="Masukkan username terdaftar..."
                        class="w-full pl-11 pr-4 py-2.5 sm:py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00685f]/50 text-xs sm:text-sm text-slate-800 transition-all min-h-[44px] @error('username') border-red-500 @enderror"
                        required autofocus>
                </div>
                @error('username')
                    <p class="text-red-500 text-[11px] sm:text-xs mt-1.5 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-slate-700 text-xs sm:text-sm font-semibold mb-1.5">Kata Sandi Baru</label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base sm:text-lg">lock</span>
                    <input type="password" name="password" placeholder="Minimal 8 karakter baru..."
                        class="w-full pl-11 pr-4 py-2.5 sm:py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00685f]/50 text-xs sm:text-sm text-slate-800 transition-all min-h-[44px] @error('password') border-red-500 @enderror"
                        required>
                </div>
                @error('password')
                    <p class="text-red-500 text-[11px] sm:text-xs mt-1.5 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-slate-700 text-xs sm:text-sm font-semibold mb-1.5">Konfirmasi Kata Sandi
                    Baru</label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base sm:text-lg">lock_clock</span>
                    <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru..."
                        class="w-full pl-11 pr-4 py-2.5 sm:py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00685f]/50 text-xs sm:text-sm text-slate-800 transition-all min-h-[44px]"
                        required>
                </div>
            </div>

            <!-- Enhanced full-width button with tap micro-interaction -->
            <button type="submit"
                class="w-full mt-2 py-3 bg-[#00685f] text-white font-bold text-xs sm:text-sm rounded-xl hover:bg-[#00574f] transition-all shadow-sm cursor-pointer active:scale-[0.98] min-h-[44px]">
                Perbarui Kata Sandi
            </button>
        </form>

        <!-- Navigasi Kembali -->
        <div class="text-center mt-6 pt-5 border-t border-slate-100">
            <p class="text-[11px] sm:text-xs text-[#3d4947] font-medium leading-relaxed">
                Ingat kata sandi Anda?
                <a href="{{ route('login') }}"
                    class="text-[#00685f] font-bold hover:underline block sm:inline-block mt-1 sm:mt-0 sm:ml-1">
                    Kembali Login
                </a>
            </p>
        </div>
    </div>

</body>

</html>
