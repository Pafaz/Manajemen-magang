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
        Schema::create('jurnal', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_peserta');
            $table->string('judul');
            $table->text('deskripsi');
            $table->date('tanggal');

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
        });

        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_peserta');
            $table->date('tanggal');
            $table->enum('metode', ['online', 'rfid'])->nullable();

            // Catatan waktu jika hadir normal
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->time('jam_istirahat')->nullable(); 
            $table->time('jam_kembali')->nullable();  

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->unique(['id_peserta', 'tanggal']);
            $table->index(['id_peserta', 'tanggal']);
        });

        Schema::create('absensi', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_peserta');
            $table->date('tanggal');

            $table->enum('status', ['alfa', 'izin', 'sakit', 'terlambat']);

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->index('id_peserta');
            $table->index(['id_peserta', 'tanggal']);
        });

        Schema::create('rekap_kehadiran', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_peserta');
            $table->tinyInteger('bulan'); // 1 - 12
            $table->smallInteger('tahun');

            $table->tinyInteger('total_terlambat')->default(0);
            $table->tinyInteger('total_hadir')->default(0);
            $table->tinyInteger('total_izin')->default(0);
            $table->tinyInteger('total_sakit')->default(0);
            $table->tinyInteger('total_alpha')->default(0);

            $table->unique(['id_peserta', 'bulan', 'tahun']);
        });

        // Schema::create('piket', function (Blueprint $table) {
        //     $table->id()->primary();
        //     $table->uuid('id_peserta');
        //     $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat']);
        //     $table->timestamps();

        //     $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
        // });

        Schema::create('piket', function (Blueprint $table) {
            $table->id();
            $table->enum('shift', ['pagi', 'sore']);
            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat']);
            $table->foreignId('id_cabang')->constrained('cabang')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('piket_peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('piket_id')->constrained('piket')->onDelete('cascade');
            $table->foreignUuid('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->timestamps();
        });        

        Schema::create('izin', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('id_peserta');
            $table->unsignedBigInteger('id_cabang');
            $table->enum('jenis', ['izin', 'sakit']);
            $table->enum('status_izin', ['diterima', 'ditolak', 'menunggu']);
            $table->string('deskripsi');
            $table->date('mulai');
            $table->date('selesai');

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
        });

        Schema::create('rfid', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_peserta');
            $table->string('rfid_code')->unique();

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
        });

        // Schema::create('laporan_piket', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('piket_id')->constrained('piket')->onDelete('cascade'); // jadwal piket
        //     $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade'); // peserta yg hadir
        //     $table->date('tanggal');
        //     $table->time('waktu_piket')->nullable();
        //     $table->enum('kehadiran', ['hadir', 'tidak hadir', 'izin'])->default('hadir');
        //     $table->text('catatan')->nullable();
        //     $table->timestamps();
        // });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal');
        Schema::dropIfExists('absensi');
        Schema::dropIfExists('piket');
        Schema::dropIfExists('izin');
        Schema::dropIfExists('piket_peserta');
    }
};
