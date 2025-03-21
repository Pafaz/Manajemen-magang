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
        Schema::create('projek', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_peserta');
            $table->id('id_divisi_cabang');
            $table->string('name');
            $table->string('deskripsi');
            $table->date('batas_waktu');
            $table->boolean('is_done');
            $table->timestamps();

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('id_divisi_cabang')->references('id')->on('divisi_cabang')->onDelete('cascade');
        });

        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('deskripsi');
        });

        Schema::create('projek_kategori', function (Blueprint $table) {
            $table->id();
            $table->id('id_projek');
            $table->id('id_kategori');

            $table->foreign('id_projek')->references('id')->on('projek')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id')->on('kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projek');
        Schema::dropIfExists('kategori');
        Schema::dropIfExists('projek_kategori');
    }
};
