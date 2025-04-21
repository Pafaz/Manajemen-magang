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
            $table->string('name');
            $table->string('alamat');
            $table->
            $table->timestamps();

            $table->foreign('id_perusahaan')->references('id')->on('perusahaan')->onDelete('cascade');
        });

        Schema::create('divisi', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('name');
        });

        Schema::create('divisi_cabang', function (Blueprint $table) {
            $table->id()->primary();
            $table->unsignedBigInteger('id_divisi');
            $table->unsignedBigInteger('id_cabang');
            $table->integer('kuota');

            $table->foreign('id_divisi')->references('id')->on('divisi')->onDelete('cascade');
            $table->foreign('id_cabang')->references('id')->on('cabang')->onDelete('cascade');
        });

        Schema::create('lowongan', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_perusahaan');
            $table->unsignedBigInteger('id_divisi_cabang');
            $table->integer('max_kuota');
            $table->timestamps();

            $table->foreign('id_perusahaan')->references('id')->on('perusahaan')->onDelete('cascade');
            $table->foreign('id_divisi_cabang')->references('id')->on('divisi_cabang')->onDelete('cascade');
        });

        Schema::create('mentor', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('id_divisi_cabang');
            $table->uuid('id_user');

            $table->foreign('id_divisi_cabang')->references('id')->on('divisi_cabang')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('admin_cabang', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('id_cabang');
            $table->uuid('id_user');

            $table->foreign('id_cabang')->references('id')->on('cabang')->onDelete('cascade');
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
        Schema::dropIfExists('divisi_cabang');
    }
};
