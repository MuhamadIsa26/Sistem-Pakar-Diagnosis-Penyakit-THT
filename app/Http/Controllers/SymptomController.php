<?php

namespace App\Http\Controllers;

use App\Models\Symptom;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SymptomController extends Controller
{
    /**
     * Menampilkan daftar semua gejala klinis
     */
    public function index(): View
    {
        $symptoms = Symptom::orderBy('code', 'asc')->get();

        return view('admin.symptom_management', compact('symptoms'));
    }

    /**
     * Menyimpan gejala baru secara manual melalui form
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:symptoms,code|max:255',
            'name' => 'required|string',
        ]);

        Symptom::create($validated);

        return redirect()->route('admin.symptoms.index')
            ->with('success', 'Data gejala klinis baru berhasil ditambahkan secara manual!');
    }

    /**
     * Menampilkan form edit gejala
     */
    public function edit($id): View
    {
        $symptom = Symptom::findOrFail($id);

        return view('admin.symptom_edit', compact('symptom'));
    }

    /**
     * Memperbarui data gejala
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $symptom = Symptom::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:symptoms,code,'.$symptom->id,
            'name' => 'required|string',
        ]);

        $symptom->update($validated);

        return redirect()->route('admin.symptoms.index')
            ->with('success', 'Data gejala berhasil diperbarui!');
    }

    /**
     * Menghapus gejala dari sistem
     */
    public function destroy($id): RedirectResponse
    {
        $symptom = Symptom::findOrFail($id);
        $symptom->delete();

        return redirect()->route('admin.symptoms.index')
            ->with('success', 'Data gejala berhasil dihapus dari sistem!');
    }

    /**
     * FITUR BARU: Memproses Mass Import File CSV ke Tabel Symptoms
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');

        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
            // Melewati baris pertama (Header: code, name)
            fgetcsv($handle, 1000, ',');

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                // Lewati jika kolom kode kosong
                if (empty($data[0])) {
                    continue;
                }

                Symptom::updateOrCreate(
                    ['code' => trim($data[0])],
                    [
                        'name' => trim($data[1]),
                    ]
                );
            }
            fclose($handle);
        }

        return redirect()->route('admin.symptoms.index')
            ->with('success', 'Massal data master gejala klinis berhasil diimport masuk ke database!');
    }
}
