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
        Schema::create('rekap_cabangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cabang')->constrained(); // Pastikan ada relasi ke tabel cabang
            $table->integer('total_peserta');
            $table->integer('total_admin');
            $table->integer('total_mentor');
            $table->integer('total_divisi');
            $table->json('peserta_per_divisi');
            $table->json('mentor_per_divisi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_cabangs');
    }
};
