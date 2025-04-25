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
        Schema::create('proyek', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_peserta');
            $table->unsignedBigInteger('id_divisi_cabang');
            $table->string('nama');
            $table->string('deskripsi');
            $table->date('batas_waktu');
            $table->boolean('is_done');
            $table->timestamps();

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('id_divisi_cabang')->references('id')->on('divisi_cabang')->onDelete('cascade');
        });

        Schema::create('kategori', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('nama');
        });

        Schema::create('proyek_kategori', function (Blueprint $table) {
            $table->unsignedBigInteger('id_proyek');
            $table->unsignedBigInteger('id_kategori');

            $table->foreign('id_proyek')->references('id')->on('proyek')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id')->on('kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyek');
        Schema::dropIfExists('kategori');
        Schema::dropIfExists('proyek_kategori');
    }
};
