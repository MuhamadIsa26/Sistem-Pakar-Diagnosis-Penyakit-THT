<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('histories', function (Blueprint $table) {
            // Menambahkan kolom JSON untuk menyimpan seluruh peringkat hasil diagnosis CF
            $table->json('diagnoses_rank')->nullable()->after('symptoms');
        });
    }

    public function down(): void
    {
        Schema::table('histories', function (Blueprint $table) {
            $table->dropColumn('diagnoses_rank');
        });
    }
};
