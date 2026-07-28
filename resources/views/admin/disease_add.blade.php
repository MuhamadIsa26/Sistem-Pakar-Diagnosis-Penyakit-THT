<!-- POP-UP MODAL CONTAINER (Global Add Disease Component) -->
<div id="diseaseModal"
    class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-all duration-300">
    <!-- Modal Content Card -->
    <div id="diseaseModalContent"
        class="bg-white text-slate-800 w-full max-w-xl p-8 rounded-xl border border-slate-200 shadow-2xl transform transition-all duration-300 scale-95 opacity-0">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Tambah Penyakit Baru</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pastikan kode penyakit unik (misal: P006) dan belum terdaftar di
                    database.</p>
            </div>
            <button type="button" id="closeDiseaseModalCross"
                class="text-slate-400 hover:text-slate-600 cursor-pointer flex items-center">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <form action="{{ route('admin.diseases.store') }}" method="POST" class="m-0">
            @csrf

            <!-- Input Kode Penyakit -->
            <div class="mb-4">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Kode Penyakit</label>
                <input type="text" name="code" placeholder="Contoh: P006" value="{{ old('code') }}"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#924628]/50 text-sm text-slate-800 @error('code') border-red-500 @enderror"
                    required>
                @error('code')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Nama Penyakit -->
            <div class="mb-4">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Nama Medis Penyakit</label>
                <input type="text" name="name" placeholder="Masukkan nama penyakit..." value="{{ old('name') }}"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#924628]/50 text-sm text-slate-800 @error('name') border-red-500 @enderror"
                    required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Deskripsi / Solusi -->
            <div class="mb-6">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Deskripsi & Solusi Penanganan</label>
                <textarea name="description" rows="4" placeholder="Masukkan ringkasan klinis beserta solusi penanganannya..."
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#924628]/50 text-sm text-slate-800 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi Kendali -->
            <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">
                <button type="button" id="closeDiseaseModalBtn"
                    class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-semibold text-white bg-[#924628] rounded-lg hover:bg-[#924628]/90 transition-colors cursor-pointer shadow-sm">
                    Simpan Penyakit
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript Global Trigger Controller -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('diseaseModal');
        const content = document.getElementById('diseaseModalContent');
        const closeCross = document.getElementById('closeDiseaseModalCross');
        const closeBtn = document.getElementById('closeDiseaseModalBtn');
        const openButtons = document.querySelectorAll('.trigger-add-disease-modal');

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                content.classList.replace('scale-95', 'scale-100');
                content.classList.replace('opacity-0', 'opacity-100');
            }, 20);
        }

        function closeModal() {
            content.classList.replace('scale-100', 'scale-95');
            content.classList.replace('opacity-100', 'opacity-0');
            setTimeout(() => {
                modal.classList.replace('flex', 'hidden');
                modal.classList.add('hidden');
            }, 150);
        }

        openButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                openModal();
            });
        });

        closeCross.addEventListener('click', closeModal);
        closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        @if ($errors->has('code') || $errors->has('name') || $errors->has('description'))
            openModal();
        @endif
    });
</script>
