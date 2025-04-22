<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('foto', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_referensi');
            $table->string('path');
            $table->enum('type', ['profile', 'banner', 'presentasi','cv', 'surat_pernyataan_diri', 'surat_pernyataan_orang_tua','jurnal', 'npwp', 'surat_legalitas']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto');
    }
};
