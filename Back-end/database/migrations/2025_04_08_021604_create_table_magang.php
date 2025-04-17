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
            $table->uuid('id_mentor');
            $table->unsignedBigInteger('id_divisi_cabang');
            $table->enum('tipe', ['offline', 'online']);
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->timestamps();

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('id_mentor')->references('id')->on('mentor')->onDelete('cascade');
            $table->foreign('id_divisi_cabang')->references('id')->on('divisi_cabang')->onDelete('cascade');
        });

        Schema::create('surat', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_peserta');
            $table->uuid('id_admin');
            $table->enum('jenis', ['penerimaan', 'peringatan']);
            $table->string('nomor');
            $table->text('isi');
            $table->string('file_path');
            $table->timestamps();

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('id_admin')->references('id')->on('admin_cabang')->onDelete('cascade');
        });

        Schema::create('jam_kantor', function (Blueprint $table) {
            $table->id()->primary();
            $table->unsignedBigInteger('id_divisi_cabang');
            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat']);
            $table->enum('jenis_sesi', ['pagi', 'siang', 'penuh']);
            $table->time('masuk');
            $table->time('istirahat_mulai');
            $table->time('istirahat_selesai');
            $table->time('pulang');
            $table->timestamps();

            $table->foreign('id_divisi_cabang')->references('id')->on('divisi_cabang')->onDelete('cascade');
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
