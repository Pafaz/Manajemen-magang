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

        Schema::create('progress', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('deskripsi');
            $table->boolean('status');

        });

        Schema::create('revisi', function (Blueprint $table) {
            $table->id()->primary();
            $table->date('tanggal');
            $table->boolean('status');
            $table->unsignedBigInteger('id_progress');

            $table->foreign('id_progress')->references('id')->on('progress')->onDelete('cascade');
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
    }
};
