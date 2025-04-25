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
        Schema::create('cabang', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_perusahaan');
            $table->string('bidang_usaha');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('website');
            $table->string('instagram');
            $table->string('linkedin');
            $table->timestamps();

            $table->foreign('id_perusahaan')->references('id')->on('perusahaan')->onDelete('cascade');
        });

        Schema::create('kategori-proyek', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_perusahaan');
            $table->string('nama');
            $table->timestamps();

            $table->foreign('id_perusahaan')->references('id')->on('perusahaan')->onDelete('cascade');
        });

        Schema::create('divisi', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('nama');
            $table->unsignedBigInteger('id_cabang')->nullable();
            $table->unsignedBigInteger('id_kategori-proyek');
            $table->uuid('id_perusahaan');

            $table->foreign('id_perusahaan')->references('id')->on('perusahaan')->onDelete('cascade');
            $table->foreign('id_kategori-proyek')->references('id')->on('kategori-proyek')->onDelete('cascade');
            $table->foreign('id_cabang')->references('id')->on('cabang')->onDelete('cascade');
        });

        Schema::create('lowongan', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_perusahaan');
            $table->unsignedBigInteger('id_cabang')->nullable();
            $table->unsignedBigInteger('id_divisi');
            $table->integer('max_kuota');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('deskripsi');
            $table->boolean('status'); //active or inactive
            $table->string('email_hrd');
            $table->timestamps();

            $table->foreign('id_perusahaan')->references('id')->on('perusahaan')->onDelete('cascade');
            $table->foreign('id_cabang')->references('id')->on('cabang')->onDelete('cascade');
            $table->foreign('id_divisi')->references('id')->on('divisi')->onDelete('cascade');
        });

        Schema::create('mentor', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('id_divisi');
            $table->uuid('id_user');

            $table->foreign('id_divisi')->references('id')->on('divisi')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('admin_cabang', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('id_cabang');
            $table->uuid('id_user');

            $table->foreign('id_cabang')->references('id')->on('cabang')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('admin_perusahaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_perusahaan');
            $table->uuid('id_user');
            // $table->timestamps();

            $table->foreign('id_perusahaan')->references('id')->on('perusahaan')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabang');
        Schema::dropIfExists('mentor');
        Schema::dropIfExists('admin_cabang');
        Schema::dropIfExists('divisi');
        Schema::dropIfExists('lowongan');
        Schema::dropIfExists('admin_perusahaan');
        Schema::dropIfExists('kategori-proyek');
    }
};
