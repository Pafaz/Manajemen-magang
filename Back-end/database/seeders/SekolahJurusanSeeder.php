<?php
namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\Jurusan;
use App\Models\JurusanSekolah;
use Illuminate\Database\Seeder;

class SekolahJurusanSeeder extends Seeder
{
    public function run(): void
    {
        // Menambahkan data Sekolah
        $sekolah1 = Sekolah::create([
            'nama' => 'Sekolah Menengah Atas 1 Jakarta',
            'alamat' => 'Jl. Raya No. 1, Jakarta',
            'telepon' => '021-1234567',
            'jenis_institusi' => 'Politeknik'
        ]);

        $sekolah2 = Sekolah::create([
            'nama' => 'Sekolah Menengah Atas 2 Bandung',
            'alamat' => 'Jl. Bandung No. 3, Bandung',
            'telepon' => '022-7654321',
            'jenis_institusi' => 'Politeknik'
        ]);

        // Menambahkan data Jurusan
        $jurusan1 = Jurusan::create([
            'nama' => 'Jurusan IPA',
        ]);

        $jurusan2 = Jurusan::create([
            'nama' => 'Jurusan IPS',
        ]);

        $jurusan3 = Jurusan::create([
            'nama' => 'Jurusan Bahasa',
        ]);

        // Menghubungkan Jurusan dengan Sekolah menggunakan tabel pivot jurusan_sekolah
        JurusanSekolah::create([
            'id_jurusan' => $jurusan1->id,
            'id_sekolah' => $sekolah1->id,
        ]);

        JurusanSekolah::create([
            'id_jurusan' => $jurusan2->id,
            'id_sekolah' => $sekolah1->id,
        ]);

        JurusanSekolah::create([
            'id_jurusan' => $jurusan3->id,
            'id_sekolah' => $sekolah2->id,
        ]);

        JurusanSekolah::create([
            'id_jurusan' => $jurusan1->id,
            'id_sekolah' => $sekolah2->id,
        ]);
    }
}
