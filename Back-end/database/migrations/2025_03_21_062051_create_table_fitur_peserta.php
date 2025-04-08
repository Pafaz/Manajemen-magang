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
        Schema::create('jurnal', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_peserta');
            $table->string('judul');
            $table->text('deskripsi');
            $table->timestamps();

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
        });

        Schema::create('absensi', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_peserta');
            $table->date('tanggal');
            $table->time('masuk');
            $table->time('istirahat');
            $table->time('kembali');
            $table->time('pulang');
            $table->enum('status', ['hadir', 'alfa', 'izin', 'sakit']);

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
        });

        Schema::create('piket', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_peserta');
            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat']);
            $table->timestamps();

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
        });

        Schema::create('izin', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_peserta');
            $table->uuid('id_admin');
            $table->unsignedBigInteger('id_absensi');
            $table->date('tanggal');
            $table->enum('status', ['izin', 'sakit']);
            $table->enum('sesi', ['pagi', 'siang', 'mahasiswa']);
            $table->enum('status_izin', ['diterima', 'ditolak', 'menunggu']);
            $table->string('alasan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->timestamps();

            $table->foreign('id_absensi')->references('id')->on('absensi')->onDelete('cascade');
            $table->foreign('id_admin')->references('id')->on('admin_cabang')->onDelete('cascade');
            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
        });

        Schema::create('rfid', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_peserta');
            $table->string('rfid_code')->unique();
            $table->timestamps();

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal');
        Schema::dropIfExists('absensi');
        Schema::dropIfExists('piket');
        Schema::dropIfExists('izin');
    }
};
