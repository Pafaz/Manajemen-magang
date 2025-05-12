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

        Schema::create('divisi', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('nama');
            $table->unsignedBigInteger('id_cabang');
            $table->timestamps();

            $table->foreign('id_cabang')->references('id')->on('cabang')->onDelete('cascade');
        });

        Schema::create('kategori_proyek', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('nama');
        });

        Schema::create('lowongan', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_perusahaan');
            $table->unsignedBigInteger('id_cabang');
            $table->unsignedBigInteger('id_divisi');
            $table->integer('max_kuota');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('requirement');
            $table->string('jobdesc');
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('id_perusahaan')->references('id')->on('perusahaan')->onDelete('cascade');
            $table->foreign('id_cabang')->references('id')->on('cabang')->onDelete('cascade');
            $table->foreign('id_divisi')->references('id')->on('divisi')->onDelete('cascade');
        });

        Schema::create('mentor', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('id_divisi');
            $table->uuid('id_user');
            $table->unsignedBigInteger('id_cabang');

            $table->foreign('id_divisi')->references('id')->on('divisi')->onDelete('cascade');
            $table->foreign('id_cabang')->references('id')->on('cabang')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('admin_cabang', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('id_cabang');
            $table->uuid('id_user');

            $table->foreign('id_cabang')->references('id')->on('cabang')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('divisi_kategori', function (Blueprint $table) {
            $table->unsignedBigInteger('id_divisi');
            $table->unsignedBigInteger('id_kategori');

            $table->foreign('id_divisi')->references('id')->on('divisi')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id')->on('kategori_proyek')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor');
        Schema::dropIfExists('admin_cabang');
        Schema::dropIfExists('divisi');
        Schema::dropIfExists('lowongan');
        Schema::dropIfExists('kategori_proyek');
        Schema::dropIfExists('divisi_kategori');
    }
};