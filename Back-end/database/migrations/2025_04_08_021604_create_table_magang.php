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
        Schema::create('magang', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_peserta');
            $table->unsignedBigInteger('id_lowongan');
            $table->uuid('id_mentor')->nullable();
            $table->unsignedBigInteger('id_divisi')->nullable();
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->date('mulai');
            $table->date('selesai');

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('id_mentor')->references('id')->on('mentor')->onDelete('cascade');
            $table->foreign('id_lowongan')->references('id')->on('lowongan')->onDelete('cascade');
            $table->foreign('id_divisi')->references('id')->on('divisi')->onDelete('cascade');
            $table->unique(['id_peserta', 'id_lowongan']);
            $table->index(['id_peserta', 'id_lowongan']); // pencarian spesifik
            $table->index(['id_lowongan', 'status']);

        });

        Schema::create('surat', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_peserta');
            $table->unsignedBigInteger('id_cabang');
            $table->string('no_surat');
            $table->enum('jenis', ['penerimaan', 'peringatan']);
            $table->string('keterangan_surat')->nullable();
            $table->string('alasan')->nullable();
            $table->string('file_path');
            $table->timestamps();

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('id_cabang')->references('id')->on('cabang')->onDelete('cascade');
        });

        Schema::create('jam_kantor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cabang');
            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu']);
            $table->time('awal_masuk');
            $table->time('akhir_masuk')->nullable();
            $table->time('awal_istirahat')->nullable();
            $table->time('akhir_istirahat')->nullable();
            $table->time('awal_kembali')->nullable();
            $table->time('akhir_kembali')->nullable();
            $table->time('awal_pulang');
            $table->time('akhir_pulang')->nullable();
            $table->boolean('status');

            $table->foreign('id_cabang')->references('id')->on('cabang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magang');
        Schema::dropIfExists('surat');
        Schema::dropIfExists('jam_kantor');
    }
};
