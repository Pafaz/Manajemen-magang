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
        Schema::create('sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('alamat');
            $table->string('telepon');
        });

        Schema::create('jurusan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
        });

        Schema::create('jurusan_sekolah', function (Blueprint $table) {
            $table->id();
            $table->id('id_jurusan');
            $table->id('id_sekolah');

            $table->foreign('id_jurusan')->references('id')->on('jurusan')->onDelete('cascade');
            $table->foreign('id_sekolah')->references('id')->on('sekolah')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolah');
        Schema::dropIfExists('jurusan');
        Schema::dropIfExists('jurusan_sekolah');
    }
};
