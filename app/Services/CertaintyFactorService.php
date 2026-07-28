<?php

namespace App\Services;

use App\Models\Rule;

class CertaintyFactorService
{
    public function calculate(array $activeSymptoms): array
    {
        $symptomIds = array_keys($activeSymptoms);

        // Ambil aturan terpicu, urutkan berdasarkan kode gejala (G001, G002...) secara sekuensial
        $triggeredRules = Rule::whereIn('symptom_id', $symptomIds)
            ->with('symptom')
            ->get()
            ->sortBy(function ($rule) {
                return $rule->symptom->code;
            })
            ->groupBy('disease_id');

        $diagnosesRank = [];

        foreach ($triggeredRules as $diseaseId => $rules) {
            $cfCombine = 0.0;
            $isFirst = true;

            foreach ($rules as $rule) {
                $cfUser = floatval($activeSymptoms[$rule->symptom_id]);
                $cfPakar = floatval($rule->cf_pakar);

                // CF Gejala = CF Pakar x CF User
                $cfCurrent = $cfPakar * $cfUser;

                // Rumus Akumulasi CF Combine
                if ($isFirst) {
                    $cfCombine = $cfCurrent;
                    $isFirst = false;
                } else {
                    $cfCombine = $cfCombine + ($cfCurrent * (1.0 - $cfCombine));
                }
            }

            if ($cfCombine > 0) {
                $diagnosesRank[] = [
                    'disease_id' => $diseaseId,
                    'confidence_value' => round($cfCombine * 100, 2),
                ];
            }
        }

        usort($diagnosesRank, function ($a, $b) {
            return $b['confidence_value'] <=> $a['confidence_value'];
        });

        return $diagnosesRank;
    }
}
