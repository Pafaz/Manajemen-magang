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
            $table->enum('tipe', ['offline', 'online']);
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->date('mulai');
            $table->date('selesai');

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('id_mentor')->references('id')->on('mentor')->onDelete('cascade');
            $table->foreign('id_lowongan')->references('id')->on('lowongan')->onDelete('cascade');
        });

        Schema::create('surat', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_peserta');
            $table->uuid('id_admin_cabang')->nullable();
            $table->uuid('id_perusahaan');
            $table->enum('jenis', ['penerimaan', 'peringatan']);
            $table->date('tanggal');
            $table->string('nomor');
            $table->text('isi');
            $table->timestamps();
            $table->string('file_path');

            $table->foreign('id_perusahaan')->references('id')->on('perusahaan')->onDelete('cascade');
            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('id_admin_cabang')->references('id')->on('admin_cabang')->onDelete('cascade');
        });

        Schema::create('jam_kantor', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_perusahaan');
            $table->unsignedBigInteger('id_cabang')->nullable();
            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat']);
            $table->enum('jenis_sesi', ['pagi', 'siang', 'penuh']);
            $table->time('masuk');
            $table->time('istirahat_mulai');
            $table->time('istirahat_selesai');
            $table->time('pulang');
            $table->timestamps();

            $table->foreign('id_cabang')->references('id')->on('cabang')->onDelete('cascade');
            $table->foreign('id_perusahaan')->references('id')->on('perusahaan')->onDelete('cascade');
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
