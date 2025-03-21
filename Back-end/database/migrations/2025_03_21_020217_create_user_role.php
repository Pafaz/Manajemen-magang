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
            $table->uuid('id');
            $table->uuid('id_user');
            $table->bigInteger('id_jurusan');
            $table->bigInteger('id_sekolah');
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
            $table->uuid('id');
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

        Schema::create('admin_perusahaan', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('id_cabang');
            $table->uuid('id_user');

            $table->foreign('id_cabang')->references('id')->on('cabang')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('mentor', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('id_divisi_cabang');
            $table->uuid('id_user');

            $table->foreign('id_divisi_cabang')->references('id')->on('divisi_cabang')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_magang');
        Schema::dropIfExists('perusahaan');
        Schema::dropIfExists('admin_perusahaan');
        Schema::dropIfExists('mentor');
    }
};
