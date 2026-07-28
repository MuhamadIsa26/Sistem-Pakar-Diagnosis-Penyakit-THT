<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CertaintyFactorSeeder extends Seeder
{
    public function run(): void
    {
        // 1. KOSONGKAN TABEL TERLEBIH DAHULU UNTUK MENGHINDARI DUPLIKASI
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('diseases')->truncate();
        DB::table('symptoms')->truncate();
        DB::table('rules')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. INPUT DATA MASTER PENYAKIT (DISEASES)
        $diseases = [
            ['id' => 1, 'code' => 'P001', 'name' => 'Otitis Media Akut (OMA)', 'description' => 'Infeksi akut pada telinga tengah.', 'solution' => 'Pemberian antibiotik sesuai resep dokter.'],
            ['id' => 2, 'code' => 'P002', 'name' => 'Serumen (Kotoran Telinga)', 'description' => 'Akumulasi kotoran telinga yang mengeras.', 'solution' => 'Tindakan irigasi telinga oleh dokter THT.'],
            ['id' => 3, 'code' => 'P003', 'name' => 'Otitis Eksterna (OE)', 'description' => 'Peradangan atau infeksi pada saluran telinga luar.', 'solution' => 'Pemberian obat tetes telinga antibiotik.'],
            ['id' => 4, 'code' => 'P004', 'name' => 'Sinusitis', 'description' => 'Inflamasi atau peradangan pada dinding sinus.', 'solution' => 'Pemberian dekongestan dan irigasi nasal.'],
            ['id' => 5, 'code' => 'P005', 'name' => 'Rhinitis Kronis', 'description' => 'Peradangan kronis pada mukosa hidung.', 'solution' => 'Menghindari alergen dan konsumsi antihistamin.'],
        ];
        DB::table('diseases')->insert($diseases);

        // 3. INPUT DATA MASTER GEJALA (SYMPTOMS)
        $symptoms = [
            ['id' => 1, 'code' => 'G001', 'name' => 'Batuk'],
            ['id' => 2, 'code' => 'G002', 'name' => 'Bersin'],
            ['id' => 3, 'code' => 'G003', 'name' => 'Dahak mengalir ditenggorok'],
            ['id' => 4, 'code' => 'G004', 'name' => 'Demam'],
            ['id' => 5, 'code' => 'G005', 'name' => 'Hidung mampet'],
            ['id' => 6, 'code' => 'G006', 'name' => 'Hidung mampet pada hidung bagian sebelah'],
            ['id' => 7, 'code' => 'G007', 'name' => 'Hidung mampet pada bagian sebelah secara bergantian'],
            ['id' => 8, 'code' => 'G008', 'name' => 'Ingus bau'],
            ['id' => 9, 'code' => 'G009', 'name' => 'Memiliki riwayat mengorek telinga'],
            ['id' => 10, 'code' => 'G010', 'name' => 'Penciuman berkurang'],
            ['id' => 11, 'code' => 'G011', 'name' => 'Pendengaran berkurang'],
            ['id' => 12, 'code' => 'G012', 'name' => 'Pilek encer di kedua hidung'],
            ['id' => 13, 'code' => 'G013', 'name' => 'Pilek'],
            ['id' => 14, 'code' => 'G014', 'name' => 'Sakit kepala'],
            ['id' => 15, 'code' => 'G015', 'name' => 'Telinga berair selama ≥ 2 bulan'],
            ['id' => 16, 'code' => 'G016', 'name' => 'Telinga berair selama ≤ 2 bulan'],
            ['id' => 17, 'code' => 'G017', 'name' => 'Telinga berair bau selama ≥ 2 bulan'],
            ['id' => 18, 'code' => 'G018', 'name' => 'Telinga mampet'],
            ['id' => 19, 'code' => 'G019', 'name' => 'Telinga gatal'],
            ['id' => 20, 'code' => 'G020', 'name' => 'Telinga nyeri'],
            ['id' => 21, 'code' => 'G021', 'name' => 'Tenggorok nyeri'],
            ['id' => 22, 'code' => 'G022', 'name' => 'Telinga nyeri saat mengunyah'],
            ['id' => 23, 'code' => 'G023', 'name' => 'Telinga berdengung'],
            ['id' => 24, 'code' => 'G024', 'name' => 'Tidur mendengkur'],
        ];
        DB::table('symptoms')->insert($symptoms);

        // 4. INPUT BASIS ATURAN PAKAR (RULES MATRIX DENGAN CF PAKAR)
        $rules = [
            // P001 - Otitis Media Akut (OMA)
            ['disease_id' => 1, 'symptom_id' => 1, 'cf_pakar' => 0.8],
            ['disease_id' => 1, 'symptom_id' => 4, 'cf_pakar' => 0.8],
            ['disease_id' => 1, 'symptom_id' => 11, 'cf_pakar' => 0.6],
            ['disease_id' => 1, 'symptom_id' => 13, 'cf_pakar' => 0.8],
            ['disease_id' => 1, 'symptom_id' => 14, 'cf_pakar' => 0.4],
            ['disease_id' => 1, 'symptom_id' => 16, 'cf_pakar' => 0.8],
            ['disease_id' => 1, 'symptom_id' => 20, 'cf_pakar' => 1.0],
            ['disease_id' => 1, 'symptom_id' => 23, 'cf_pakar' => 0.6],

            // P002 - Serumen (Kotoran Telinga)
            ['disease_id' => 2, 'symptom_id' => 9, 'cf_pakar' => 0.4],
            ['disease_id' => 2, 'symptom_id' => 11, 'cf_pakar' => 0.8],
            ['disease_id' => 2, 'symptom_id' => 18, 'cf_pakar' => 1.0],
            ['disease_id' => 2, 'symptom_id' => 19, 'cf_pakar' => 0.2],

            // P003 - Otitis Eksterna (OE)
            ['disease_id' => 3, 'symptom_id' => 9, 'cf_pakar' => 0.8],
            ['disease_id' => 3, 'symptom_id' => 11, 'cf_pakar' => 0.8],
            ['disease_id' => 3, 'symptom_id' => 16, 'cf_pakar' => 0.4],
            ['disease_id' => 3, 'symptom_id' => 18, 'cf_pakar' => 0.6],
            ['disease_id' => 3, 'symptom_id' => 19, 'cf_pakar' => 0.8],
            ['disease_id' => 3, 'symptom_id' => 20, 'cf_pakar' => 1.0],
            ['disease_id' => 3, 'symptom_id' => 23, 'cf_pakar' => 0.6],

            // P004 - Sinusitis
            ['disease_id' => 4, 'symptom_id' => 1, 'cf_pakar' => 0.4],
            ['disease_id' => 4, 'symptom_id' => 3, 'cf_pakar' => 0.8],
            ['disease_id' => 4, 'symptom_id' => 4, 'cf_pakar' => 0.4],
            ['disease_id' => 4, 'symptom_id' => 5, 'cf_pakar' => 0.4],
            ['disease_id' => 4, 'symptom_id' => 6, 'cf_pakar' => 0.6],
            ['disease_id' => 4, 'symptom_id' => 10, 'cf_pakar' => 0.6],
            ['disease_id' => 4, 'symptom_id' => 12, 'cf_pakar' => 0.6],
            ['disease_id' => 4, 'symptom_id' => 14, 'cf_pakar' => 1.0],

            // P005 - Rhinitis Kronis
            ['disease_id' => 5, 'symptom_id' => 2, 'cf_pakar' => 0.8],
            ['disease_id' => 5, 'symptom_id' => 5, 'cf_pakar' => 0.8],
            ['disease_id' => 5, 'symptom_id' => 7, 'cf_pakar' => 0.8],
            ['disease_id' => 5, 'symptom_id' => 10, 'cf_pakar' => 0.6],
            ['disease_id' => 5, 'symptom_id' => 12, 'cf_pakar' => 1.0],
            ['disease_id' => 5, 'symptom_id' => 13, 'cf_pakar' => 1.0],
            ['disease_id' => 5, 'symptom_id' => 14, 'cf_pakar' => 0.4],
        ];
        DB::table('rules')->insert($rules);
    }
}
