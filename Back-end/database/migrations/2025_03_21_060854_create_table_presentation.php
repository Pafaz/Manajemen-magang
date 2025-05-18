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
            $table->boolean('status')->nullable();
            $table->string('projek')->nullable();
            $table->timestamps();
            
            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('id_jadwal_presentasi')->references('id')->on('jadwal_presentasi')->onDelete('cascade');
        });

        Schema::create('route', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_peserta');
            $table->unsignedBigInteger('id_kategori_proyek');
            $table->date('mulai')->nullable();
            $table->date('selesai')->nullable();

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('id_kategori_proyek')->references('id')->on('kategori_proyek')->onDelete('cascade');
        });

        Schema::create('revisi', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_peserta');
            $table->unsignedBigInteger('id_route');
            $table->boolean('status')->default(false); // false = belum diterima
            $table->timestamps();

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('id_route')->references('id')->on('route')->onDelete('cascade');
        });

        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_revisi');
            $table->string('deskripsi');
            $table->boolean('status')->default(false); // false = belum selesai

            $table->foreign('id_revisi')->references('id')->on('revisi')->onDelete('cascade');
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
        Schema::dropIfExists('progress');
        Schema::dropIfExists('route');
    }
};
