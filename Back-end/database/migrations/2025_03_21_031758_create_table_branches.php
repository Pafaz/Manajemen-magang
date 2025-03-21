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
            $table->id();
            $table->uuid('id_perusahaan');
            $table->string('name');
            $table->string('alamat');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('id_perusahaan')->references('id')->on('perusahaan')->onDelete('cascade');
        });

        Schema::create('divisi', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('divisi_cabang', function (Blueprint $table) {
            $table->id();
            $table->id('id_divisi');
            $table->id('id_cabang');
            $table->integer('kuota');

            $table->foreign('id_divisi')->references('id')->on('divisi')->onDelete('cascade');
            $table->foreign('id_cabang')->references('id')->on('cabang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabang');
        Schema::dropIfExists('divisi');
        Schema::dropIfExists('divisi_cabang');
    }
};
