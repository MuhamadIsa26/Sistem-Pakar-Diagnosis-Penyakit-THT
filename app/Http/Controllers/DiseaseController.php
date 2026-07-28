<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DiseaseController extends Controller
{
    /**
     * Menampilkan daftar semua penyakit
     */
    public function index(): View
    {
        $diseases = Disease::orderBy('code', 'asc')->get();

        return view('admin.disease_management', compact('diseases'));
    }

    /**
     * Menyimpan penyakit baru secara manual melalui form
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:diseases,code|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'solution' => 'nullable|string',
        ]);

        Disease::create($validated);

        return redirect()->route('admin.diseases.index')
            ->with('success', 'Data penyakit baru berhasil ditambahkan secara manual!');
    }

    /**
     * Menampilkan form edit penyakit
     */
    public function edit($id): View
    {
        $disease = Disease::findOrFail($id);

        return view('admin.disease_edit', compact('disease'));
    }

    /**
     * Memperbarui data penyakit
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $disease = Disease::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:diseases,code,'.$disease->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'solution' => 'nullable|string',
        ]);

        $disease->update($validated);

        return redirect()->route('admin.diseases.index')
            ->with('success', 'Data penyakit berhasil diperbarui!');
    }

    /**
     * Menghapus penyakit dari sistem
     */
    public function destroy($id): RedirectResponse
    {
        $disease = Disease::findOrFail($id);
        $disease->delete();

        return redirect()->route('admin.diseases.index')
            ->with('success', 'Data penyakit berhasil dihapus dari sistem!');
    }

    /**
     * FITUR BARU: Memproses Mass Import File CSV ke Tabel Diseases
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');

        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
            // Melewati baris pertama (Header: code, name, description, solution)
            fgetcsv($handle, 1000, ',');

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                // Lewati baris jika kolom kode kosong
                if (empty($data[0])) {
                    continue;
                }

                Disease::updateOrCreate(
                    ['code' => trim($data[0])],
                    [
                        'name' => trim($data[1]),
                        'description' => isset($data[2]) ? trim($data[2]) : null,
                        'solution' => isset($data[3]) ? trim($data[3]) : null,
                    ]
                );
            }
            fclose($handle);
        }

        return redirect()->route('admin.diseases.index')
            ->with('success', 'Data sudah berhasil di import!');
    }
}
