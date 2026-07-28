<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use App\Models\Rule;
use App\Models\Symptom;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RuleController extends Controller
{
    /**
     * Menampilkan Halaman Basis Pengetahuan (Knowledge Base)
     */
    public function index(): View
    {
        $rules = Rule::with(['disease', 'symptom'])->get()->groupBy('disease_id');

        $diseases = Disease::orderBy('code', 'asc')->get();
        $symptoms = Symptom::orderBy('code', 'asc')->get();

        return view('admin.rule_management', compact('rules', 'diseases', 'symptoms'));
    }

    /**
     * Menyimpan Aturan Relasi Baru ke Database secara Manual
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input serta menangkap bobot nilai cf_pakar dari form
        $validated = $request->validate([
            'disease_id' => ['required', 'exists:diseases,id'],
            'symptom_id' => ['required', 'exists:symptoms,id'],
            'cf_pakar' => ['required', 'numeric', 'min:0', 'max:1'],
        ]);

        $isDuplicate = Rule::where('disease_id', $request->disease_id)
            ->where('symptom_id', $request->symptom_id)
            ->exists();

        if ($isDuplicate) {
            return back()->withErrors([
                'symptom_id' => 'Gejala ini sudah terikat pada penyakit yang Anda pilih.',
            ])->withInput();
        }

        // Menggunakan $validated agar terhindar dari error mass assignment '_token'
        Rule::create($validated);

        return redirect()->route('admin.rules.index')->with('success', 'Aturan baru berhasil didefinisikan!');
    }

    /**
     * Menghapus Aturan Relasi dari Database
     */
    public function destroy(Rule $rule): RedirectResponse
    {
        $rule->delete();

        return redirect()->route('admin.rules.index')->with('success', 'Aturan relasi berhasil dilepas!');
    }

    /**
     * Memproses Mass Import Aturan Berdasarkan Kode CSV (disease_code, symptom_code, cf_pakar)
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');

        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
            fgetcsv($handle, 1000, ','); // Melewati baris pertama (Header)

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if (empty($data[0]) || empty($data[1])) {
                    continue;
                }

                // Konversi string kode dari CSV menjadi ID internal database secara otomatis
                $disease = Disease::where('code', trim($data[0]))->first();
                $symptom = Symptom::where('code', trim($data[1]))->first();

                if ($disease && $symptom) {
                    Rule::updateOrCreate(
                        [
                            'disease_id' => $disease->id,
                            'symptom_id' => $symptom->id,
                        ],
                        [
                            'cf_pakar' => floatval($data[2]),
                        ]
                    );
                }
            }
            fclose($handle);
        }

        return redirect()->route('admin.rules.index')->with('success', 'Matriks basis aturan Certainty Factor berhasil disinkronisasi!');
    }
}
