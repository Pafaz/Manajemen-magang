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
        Schema::create('peserta', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_user');
            $table->string('jurusan');
            $table->string('sekolah');
            $table->string('nomor_identitas');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('alamat');
            
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });


        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_user');
            $table->string('judul');
            $table->text('isi');
            $table->boolean('status')->default(false);
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('peserta');
    }
};
