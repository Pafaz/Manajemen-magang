<?php

namespace Database\Seeders;

use App\Models\Cabang;
use App\Models\Foto;
use App\Models\User;
use App\Models\Perusahaan;
use Illuminate\Support\Str;
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
            'name' => 'Perusahaan',
            'email' => 'perusahaan@example',
            'password' => bcrypt('password'),
        ]);

        $perusahaan->assignRole('perusahaan');

        $perusahaan_record = Perusahaan::create([
            'id' => Str::uuid(),  // Membuat UUID baru
            'id_user' => $perusahaan->id,  // Menyambungkan perusahaan ke user pertama
            'deskripsi' => 'Perusahaan teknologi yang bergerak di bidang software development dan IT consulting.',
            'provinsi' => 'DKI Jakarta',
            'kota' => 'Jakarta Selatan',
            'alamat' => 'Jl. Teknologi No.1, Jakarta',
            'kode_pos' => '12345',
            'website' => 'https://www.perusahaan-example.com',
            'instagram' => 'https://www.instagram.com/perusahaan_example',
            'bidang_usaha' => 'Software Development',
        ]);

        Foto::create([
            'id_referensi' => $perusahaan->id,  // Menyambungkan foto ke perusahaan
            'path' => 'uploads/foto/npwp_perusahaan_' . Str::uuid() . '.jpg',  // Path file (sesuaikan dengan lokasi file)
            'type' => 'npwp',  // Tipe file
        ]);

        // Menambahkan foto legalitas_perusahaan
        Foto::create([
            'id_referensi' => $perusahaan->id,  // Menyambungkan foto ke perusahaan
            'path' => 'uploads/foto/legalitas_perusahaan_' . Str::uuid() . '.jpg',  // Path file (sesuaikan dengan lokasi file)
            'type' => 'surat_legalitas',  // Tipe file
        ]);

        // Menambahkan foto logo_perusahaan
        Foto::create([
            'id_referensi' => $perusahaan->id,  // Menyambungkan foto ke perusahaan
            'path' => 'uploads/foto/profile_' . Str::uuid() . '.jpg',  // Path file (sesuaikan dengan lokasi file)
            'type' => 'profile',  // Tipe file
        ]);

        Cabang::create([
            'name' => 'Cabang 1',
            'alamat' => 'Jl. Cabang 1, Jakarta',
            'id_perusahaan' => $perusahaan_record->id
        ]);
    }
}
