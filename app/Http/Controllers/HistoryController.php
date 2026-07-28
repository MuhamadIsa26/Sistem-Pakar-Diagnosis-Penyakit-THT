<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use App\Models\History;
use App\Models\Symptom;
use App\Services\CertaintyFactorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HistoryController extends Controller
{
    protected $cfService;

    /**
     * Dependency Injection: Menyuntikkan CertaintyFactorService ke Controller[cite: 7]
     */
    public function __construct(CertaintyFactorService $cfService)
    {
        $this->cfService = $cfService;
    }

    /**
     * FITUR ADMIN: Menampilkan Halaman Log Riwayat Global (Khusus Area Admin)
     */
    public function index(): View
    {
        // Mengambil seluruh data riwayat rekam medis terurut dari yang terbaru
        $histories = History::with('disease')->latest()->get();

        // Mengarah ke halaman view manajemen log riwayat di panel admin
        return view('admin.history_index', compact('histories'));
    }

    /**
     * FITUR ADMIN: Menghapus Data Log Riwayat Rekam Medis dari Database
     */
    public function destroy(History $history): RedirectResponse
    {
        $history->delete();

        return back()->with('success', 'Catatan log riwayat rekam medis berhasil dihapus dari database.');
    }

    /**
     * TAHAP 1: Menampilkan Halaman Form Kuesioner (Symptom Selection)[cite: 7]
     */
    public function showQuestionnaire(): View
    {
        $symptoms = Symptom::orderBy('code', 'asc')->get();

        return view('patient.diagnosis_questionnaire', compact('symptoms'));
    }

    /**
     * TAHAP 2: Memproses Input Gejala & Mengeksekusi Rumus Matematika CF[cite: 7]
     */
    public function processDiagnosis(Request $request): RedirectResponse
    {
        $inputs = $request->input('symptoms', []);

        $activeSymptoms = [];
        foreach ($inputs as $symptomId => $choice) {

            $cfValue = 0;
            switch ($choice) {
                case 'sangat_yakin':
                    $cfValue = 1;
                    break;
                case 'yakin':
                    $cfValue = 0.8;
                    break;
                case 'cukup_yakin':
                    $cfValue = 0.6;
                    break;
                case 'kurang_yakin':
                    $cfValue = 0.4;
                    break;
                case 'tidak_tahu':
                    $cfValue = 0.2;
                    break;
                case 'tidak':
                    $cfValue = 0;
                    break;
                default:
                    $cfValue = 0;
                    break;
            }

            if ($cfValue > 0) {
                $activeSymptoms[$symptomId] = $cfValue;
            }
        }

        if (empty($activeSymptoms)) {
            return back()->with('error', 'Silakan tentukan tingkat keyakinan minimal untuk salah satu gejala.');
        }

        $diagnosesRank = $this->cfService->calculate($activeSymptoms);

        $highestDiagnosis = ! empty($diagnosesRank) ? $diagnosesRank[0] : [
            'disease_id' => 1,
            'confidence_value' => 0.00,
        ];

        $symptomIds = array_keys($activeSymptoms);
        $symptomsData = [];
        $allSymptoms = Symptom::whereIn('id', $symptomIds)->get()->keyBy('id');

        foreach ($activeSymptoms as $sId => $val) {
            if (isset($allSymptoms[$sId])) {
                $symptomsData[] = [
                    'code' => $allSymptoms[$sId]->code,
                    'name' => $allSymptoms[$sId]->name,
                    'cf_user' => $val,
                ];
            }
        }

        $rankData = [];
        if (! empty($diagnosesRank)) {
            $diseaseIds = array_column($diagnosesRank, 'disease_id');
            $allDiseases = Disease::whereIn('id', $diseaseIds)->get()->keyBy('id');

            foreach ($diagnosesRank as $rank) {
                $dId = $rank['disease_id'];
                if (isset($allDiseases[$dId])) {
                    $rankData[] = [
                        'disease_id' => $dId,
                        'code' => $allDiseases[$dId]->code,
                        'name' => $allDiseases[$dId]->name,
                        'confidence_value' => $rank['confidence_value'],
                    ];
                }
            }
        }

        // SINKRONISASI FINAL: symptoms di-encode manual, diagnoses_rank dikirim raw array[cite: 7]
        $history = History::create([
            'user_id' => auth()->id(),
            'patient_name' => auth()->user()->nama ?? auth()->user()->name,
            'disease_id' => $highestDiagnosis['disease_id'],
            'confidence_value' => $highestDiagnosis['confidence_value'],
            'symptoms' => json_encode($symptomsData),
            'diagnoses_rank' => $rankData,
        ]);

        return redirect()->route('patient.diagnosis.result', $history->id)
            ->with('success', 'Diagnosis Certainty Factor selesai dihitung!');
    }

    /**
     * TAHAP 3: Menampilkan Laporan Hasil Akhir Diagnosis Komprehensif[cite: 7]
     */
    public function showResult($id): View
    {
        $history = History::with('disease')->findOrFail($id);

        // Mengurai data peringkat dengan arsitektur defensive array parsing[cite: 7]
        $rankData = is_array($history->diagnoses_rank)
            ? $history->diagnoses_rank
            : (json_decode($history->diagnoses_rank, true) ?? []);

        // Failsafe Engine jika kolom database kosong/terbaca null akibat riwayat corrupt terdahulu[cite: 7]
        if (empty($rankData)) {
            $symptomsLog = is_array($history->symptoms)
                ? $history->symptoms
                : (json_decode($history->symptoms, true) ?? []);

            $activeSymptoms = [];
            foreach ($symptomsLog as $sLog) {
                $symptomModel = Symptom::where('code', $sLog['code'])->first();
                if ($symptomModel) {
                    $activeSymptoms[$symptomModel->id] = $sLog['cf_user'];
                }
            }

            if (! empty($activeSymptoms)) {
                $recalculatedRank = $this->cfService->calculate($activeSymptoms);
                foreach ($recalculatedRank as $rank) {
                    $rankData[] = [
                        'disease_id' => $rank['disease_id'],
                        'confidence_value' => $rank['confidence_value'],
                    ];
                }
            }
        }

        // Menyusun koleksi peringkat penyakit untuk dikirimkan ke Blade[cite: 7]
        $allRankings = collect();
        foreach ($rankData as $rank) {
            $diseaseModel = Disease::find($rank['disease_id']);
            if ($diseaseModel) {
                $allRankings->push((object) [
                    'disease' => $diseaseModel,
                    'confidence_value' => $rank['confidence_value'] ?? 0,
                ]);
            }
        }

        // 1. Peringkat 2 sampai 4 dimasukkan ke Diferensiasi Diagnosis Alternatif[cite: 7]
        $alternativeDiagnosis = $allRankings->slice(1, 3);

        // 2. Peringkat 5 ke bawah dimasukkan ke Extended Pathological Variance[cite: 7]
        $extendedVariance = $allRankings->slice(4);

        return view('patient.comprehensive_ranking', compact(
            'history',
            'alternativeDiagnosis',
            'extendedVariance'
        ));
    }
}
