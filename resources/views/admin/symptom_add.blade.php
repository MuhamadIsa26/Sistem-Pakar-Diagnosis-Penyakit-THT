<!-- POP-UP MODAL CONTAINER (Global Add Symptom Component) -->
<div id="symptomModal"
    class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-all duration-300">

    <!-- PERBAIKAN: Mengubah nama ID kartu putih menjadi symptomModalContent agar tidak tabrakan -->
    <div id="symptomModalContent"
        class="bg-white text-slate-800 w-full max-w-xl p-8 rounded-xl border border-slate-200 shadow-2xl transform transition-all duration-300 scale-95 opacity-0 block">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Tambah Gejala Baru</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pastikan kode gejala unik dan tidak duplikat di dalam basis
                    sistem pakar.</p>
            </div>
            <button type="button" id="closeModalCross"
                class="text-slate-400 hover:text-slate-600 cursor-pointer flex items-center">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <form action="{{ route('admin.symptoms.store') }}" method="POST" class="m-0">
            @csrf
            <!-- Form Input Fields (Code & Name) -->
            <div class="mb-4">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Kode Gejala</label>
                <input type="text" name="code" placeholder="Contoh: G001" value="{{ old('code') }}"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00685f]/50 text-sm text-slate-800 @error('code') border-red-500 @enderror"
                    required>
                @error('code')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Nama / Kondisi Gejala</label>
                <textarea name="name" rows="3" placeholder="Masukkan deskripsi klinis gejala..."
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00685f]/50 text-sm text-slate-800 @error('name') border-red-500 @enderror"
                    required>{{ old('name') }}</textarea>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">
                <button type="button" id="closeModalBtn"
                    class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors cursor-pointer">Batal</button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-semibold text-white bg-[#00685f] rounded-lg hover:bg-[#00685f]/90 transition-colors cursor-pointer shadow-sm">Simpan
                    Gejala</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('symptomModal');
        // PERBAIKAN: Mengambil target ID baru yang sudah diubah agar manipulasi class CSS tepat sasaran
        const modalContent = document.getElementById('symptomModalContent');
        const closeCross = document.getElementById('closeModalCross');
        const closeBtn = document.getElementById('closeModalBtn');
        const openButtons = document.querySelectorAll('.trigger-add-symptom-modal');

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 20);
        }

        function closeModal() {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 150);
        }

        openButtons.forEach(button => button.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        }));
        closeCross.addEventListener('click', closeModal);
        closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        @if ($errors->has('code') || $errors->has('name'))
            openModal();
        @endif
    });
</script>
