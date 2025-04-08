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
            $table->unsignedBigInteger('id_jurusan');
            $table->unsignedBigInteger('id_sekolah');
            $table->string('nomor_identitas');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('kelas', [ '11','12', 'Mahasiswa']);
            $table->string('alamat');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_jurusan')->references('id')->on('jurusan')->onDelete('cascade');
            $table->foreign('id_sekolah')->references('id')->on('sekolah')->onDelete('cascade');
        });

        Schema::create('perusahaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_user');
            $table->string('deskripsi');
            $table->string('alamat');
            $table->string('website');
            $table->string('instagram');
            $table->boolean('is_premium');
            $table->boolean('status');
            $table->integer('jumlah_peserta');
            $table->integer('cabang_limit')->default(1);
            $table->integer('admin_limit')->default(1);
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
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
        Schema::dropIfExists('perusahaan');
        Schema::dropIfExists('peserta');
    }
};
