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
        Schema::create('jadwal_presentasi', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_mentor');
            $table->integer('kuota');
            $table->string('link_zoom')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->enum('tipe',['offline', 'online']); 
            $table->enum('status',['dijadwalkan','selesai']);
            $table->timestamps();

            $table->foreign('id_mentor')->references('id')->on('mentor')->onDelete('cascade');
        });

        Schema::create('presentasi', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_peserta');
            $table->unsignedBigInteger('id_jadwal_presentasi');
            $table->enum('status', ['menunggu','hadir', 'tidak hadir'])->default('menunggu');
            $table->string('projek')->nullable();
            $table->timestamps();

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('id_jadwal_presentasi')->references('id')->on('jadwal_presentasi')->onDelete('cascade');
        });

        Schema::create('revisi', function (Blueprint $table) {
            $table->id()->primary();
            $table->unsignedBigInteger('id_presentasi');
            $table->string('deskripsi');
            $table->boolean('status');

            $table->foreign('id_presentasi')->references('id')->on('jadwal_presentasi')->onDelete('cascade');
        });

        Schema::create('mentor_magang', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_peserta');
            $table->uuid('id_mentor');

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('id_mentor')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('progress', function (Blueprint $table) {
            $table->id()->primary();
            $table->unsignedBigInteger('id_mentor_magang');
            $table->string('deskripsi');
            $table->boolean('status');

            $table->foreign('id_mentor_magang')->references('id')->on('mentor_magang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_presentasi');
        Schema::dropIfExists('peserta_presentasi');
        Schema::dropIfExists('revisi');
        Schema::dropIfExists('mentor_magang');
        Schema::dropIfExists('progress');
    }
};
