<!-- Global Rule Modal -->
<div id="ruleModal"
    class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-all duration-300">
    <div id="modalContent"
        class="bg-white text-slate-800 w-full max-w-xl p-8 rounded-xl border border-slate-200 shadow-2xl transform transition-all duration-300 scale-95 opacity-0">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Definisikan Aturan Baru</h2>
                <p class="text-xs text-slate-500 mt-0.5">Ikatkan gejala ke indikasi penyakit.</p>
            </div>
            <button type="button" id="closeRuleModalCross" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form action="{{ route('admin.rules.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Pilih Penyakit (Konklusi)</label>
                <select name="disease_id"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#00685f]/50 text-sm"
                    required>
                    <option value="">-- Pilih Penyakit --</option>
                    @foreach ($diseases as $disease)
                        <option value="{{ $disease->id }}" {{ old('disease_id') == $disease->id ? 'selected' : '' }}>
                            [{{ $disease->code }}] {{ $disease->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Pilih Gejala Terikat (Premis)</label>
                <select name="symptom_id"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#00685f]/50 text-sm"
                    required>
                    <option value="">-- Pilih Gejala --</option>
                    @foreach ($symptoms as $symptom)
                        <option value="{{ $symptom->id }}" {{ old('symptom_id') == $symptom->id ? 'selected' : '' }}>
                            [{{ $symptom->code }}] {{ $symptom->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">
                <button type="button" id="closeRuleModalBtn"
                    class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 cursor-pointer">Batal</button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-semibold text-white bg-[#00685f] rounded-lg hover:bg-[#00685f]/90 cursor-pointer shadow-sm">Ikatkan
                    Aturan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('ruleModal');
        const modalContent = document.getElementById('modalContent');
        const openButtons = document.querySelectorAll('.trigger-add-rule-modal');

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modalContent.classList.replace('scale-95', 'scale-100');
                modalContent.classList.replace('opacity-0', 'opacity-100');
            }, 10);
        }

        function closeModal() {
            modalContent.classList.replace('scale-100', 'scale-95');
            modalContent.classList.replace('opacity-100', 'opacity-0');
            setTimeout(() => {
                modal.classList.replace('flex', 'hidden');
            }, 150);
        }

        openButtons.forEach(btn => btn.addEventListener('click', openModal));
        document.getElementById('closeRuleModalCross').addEventListener('click', closeModal);
        document.getElementById('closeRuleModalBtn').addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        @if ($errors->any())
            openModal();
        @endif
    });
</script>
