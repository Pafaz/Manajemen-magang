<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cabang;
use App\Models\Divisi;
use App\Models\Kategori;
use App\Models\Perusahaan;
use App\Models\Divisi_Kategori;
use App\Models\Jam_Kantor;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perusahaan = User::create([
            'id' => Str::uuid(),
            'nama' => 'PT. Elang Jaya',
            'email' => 'elang@gmail.com',
            'password' => bcrypt('password'),
            'id_cabang_aktif' => 1,
        ]);

        $perusahaan->assignRole('perusahaan');

        $perusahaan_record = Perusahaan::create([
            'id'=> Str::uuid(),
            'id_user' => $perusahaan->id,
            'deskripsi' => 'Berdiri sejak tahun 2022 dan bergerak di bidang software development',
            'provinsi' => 'Jawa Barat',
            'kota' => 'Bandung',
            'kecamatan' => 'Bandung Utara',
            'alamat' => 'Jalan Ikan Hiu No.13',
            'kode_pos' => '68417',
            'website' => 'https://www.elang.com',
            'is_premium' => false,
            'is_active' => true,
            'cabang_limit' => 1,
            'nama_penanggung_jawab' => 'Afif CS',
            'nomor_penanggung_jawab' => '087773827374',
            'jabatan_penanggung_jawab' => 'HRD',
            'email_penanggung_jawab' => 'afifhrd@gmail.com',
            'tanggal_berdiri' => '2025-01-06',
        ]);

        $cabang_record = Cabang::create([
            'id' => 1,
            'id_perusahaan' => $perusahaan_record->id,
            'nama'=> 'PT. Elang Jember',
            'bidang_usaha' => 'Software Development',
            'provinsi' => 'Jawa Timur',
            'kota'=> 'Jember',
        ]);

        $divisi_record = Divisi::create([
            'id'=> 1,
            'nama' => 'Fullstack web developer',
            'id_cabang' => $cabang_record->id,
            'created_at' => Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]);

        $kategori_record = Kategori::create([
            'id'=> 1,
            'nama'=> 'Pengenalan',
        ]);

        $divisi_kategori = Divisi_Kategori::create([
            'id_divisi' => $divisi_record->id,
            'id_kategori' => $kategori_record->id
        ]);

        Jam_Kantor::create([
            'id'=> 1,
            'id_cabang' => $cabang_record->id,
            'hari' => 'senin',
            'awal_masuk' => '07:00',
            'akhir_masuk' => '08:00',
            'awal_istirahat' => '12:00',
            'akhir_istirahat' => '13:00',
            'awal_kembali' => '12:45',
            'akhir_kembali' => '13:00',
            'awal_pulang' => '16:00',
            'akhir_pulang' => '17:00',
            'status' => true,
        ]);

        Jam_Kantor::create([
            'id'=> 2,
            'id_cabang' => $cabang_record->id,
            'hari' => 'selasa',
            'awal_masuk' => '07:00',
            'akhir_masuk' => '08:00',
            'awal_istirahat' => '12:00',
            'akhir_istirahat' => '13:00',
            'awal_kembali' => '12:45',
            'akhir_kembali' => '13:00',
            'awal_pulang' => '16:00',
            'akhir_pulang' => '17:00',
            'status' => true,
        ]);

        Jam_Kantor::create([
            'id'=> 3,
            'id_cabang' => $cabang_record->id,
            'hari' => 'rabu',
            'awal_masuk' => '07:00',
            'akhir_masuk' => '08:00',
            'awal_istirahat' => '12:00',
            'akhir_istirahat' => '13:00',
            'awal_kembali' => '12:45',
            'akhir_kembali' => '13:00',
            'awal_pulang' => '16:00',
            'akhir_pulang' => '17:00',
            'status' => true,
        ]);

        Jam_Kantor::create([
            'id'=> 4,
            'id_cabang' => $cabang_record->id,
            'hari' => 'kamis',
            'awal_masuk' => '07:00',
            'akhir_masuk' => '08:00',
            'awal_istirahat' => '12:00',
            'akhir_istirahat' => '13:00',
            'awal_kembali' => '12:45',
            'akhir_kembali' => '13:00',
            'awal_pulang' => '16:00',
            'akhir_pulang' => '17:00',
            'status' => true,
        ]);

        Jam_Kantor::create([
            'id'=> 5,
            'id_cabang' => $cabang_record->id,
            'hari' => 'jumat',
            'awal_masuk' => '07:00',
            'akhir_masuk' => '08:00',
            'awal_istirahat' => '12:00',
            'akhir_istirahat' => '13:00',
            'awal_kembali' => '12:45',
            'akhir_kembali' => '13:00',
            'awal_pulang' => '16:00',
            'akhir_pulang' => '17:00',
            'status' => true,
        ]);
    }
}