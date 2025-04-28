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
            $table->id()->primary();
            $table->string('nama');
            $table->string('alamat');
            $table->string('telepon');
            $table->string('jenis_institusi');
            $table->string('website')->nullable();
            $table->uuid('id_perusahaan');

            $table->foreign('id_perusahaan')->references('id')->on('perusahaan')->onDelete('cascade');
        });

        Schema::create('jurusan', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('nama');
        });

        Schema::create('jurusan_sekolah', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jurusan');
            $table->unsignedBigInteger('id_sekolah');
        
            $table->primary(['id_jurusan', 'id_sekolah']);
        
            $table->foreign('id_jurusan')->references('id')->on('jurusan')->onDelete('cascade');
            $table->foreign('id_sekolah')->references('id')->on('sekolah')->onDelete('cascade');
        });        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan_sekolah');
        Schema::dropIfExists('jurusan');
        Schema::dropIfExists('sekolah');
    }
};
