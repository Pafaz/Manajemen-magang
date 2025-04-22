<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Peserta;
use App\Models\Jurusan;
use App\Models\Sekolah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PesertaSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil jurusan dan sekolah pertama untuk setiap peserta
        $jurusan = Jurusan::first(); // Pastikan sudah ada jurusan di database
        $sekolah = Sekolah::first(); // Pastikan sudah ada sekolah di database

        // Membuat 5 peserta dan menghubungkannya dengan jurusan, sekolah, dan user
        for ($i = 1; $i <= 5; $i++) {
            // Membuat user peserta
            $pesertaUser = User::create([
                'id' => Str::uuid(),
                'name' => 'Peserta ' . $i,
                'email' => 'peserta' . $i . '@example.com',
                'password' => bcrypt('password'),
            ]);
            $pesertaUser->assignRole('peserta'); // Menetapkan role peserta

            // Menambahkan peserta ke tabel peserta
            Peserta::create([
                'id' => Str::uuid(),
                'id_user' => $pesertaUser->id,  // Menghubungkan peserta dengan user
                'id_jurusan' => $jurusan->id,   // Menghubungkan peserta dengan jurusan
                'id_sekolah' => $sekolah->id,   // Menghubungkan peserta dengan sekolah
                'nomor_identitas' => 'ID' . $i,
                'tempat_lahir' => 'Tempat ' . $i,
                'tanggal_lahir' => now()->subYears(18)->toDateString(),  // Contoh tanggal lahir (18 tahun lalu)
                'jenis_kelamin' => $i % 2 === 0 ? 'L' : 'P',  // Alternating jenis kelamin
                'kelas' => $i <= 3 ? '11' : '12',  // 3 peserta di kelas 11, sisanya di kelas 12
                'alamat' => 'Alamat Peserta ' . $i,
            ]);
        }
    }
}
