<?php
namespace Database\Seeders;

use App\Models\Foto;
use App\Models\User;
use App\Models\Magang;
use App\Models\Peserta;
use App\Models\Lowongan;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class PesertaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $jurusanList = [
            'Teknik Komputer dan Jaringan',
            'Rekayasa Perangkat Lunak',
            'Multimedia',
            'Sistem Informasi Jaringan dan Aplikasi',
            'Teknik Elektronika Industri',
            'Teknik Mesin',
            'Teknik Otomotif',
            'Teknik Listrik',
            'Akuntansi dan Keuangan Lembaga',
            'Otomatisasi dan Tata Kelola Perkantoran',
            'Bisnis Daring dan Pemasaran',
            'Perhotelan',
            'Tata Boga',
            'Tata Busana',
            'Desain Komunikasi Visual',
            'Farmasi Klinis dan Komunitas',
            'Keperawatan',
            'Analisis Kesehatan',
            'IPA',
            'Matematika dan Ilmu Alam',
            'IPS',
            'Ilmu Pengetahuan Sosial',
            'Teknik Informatika',
            'Sistem Informasi',
            'Ilmu Komputer',
            'Teknik Elektro',
            'Teknik Mesin',
            'Teknik Sipil',
            'Arsitektur',
            'Akuntansi',
            'Manajemen',
            'Ekonomi',
            'Hukum',
            'Psikologi',
            'Kedokteran',
            'Farmasi',
            'Keperawatan',
            'Pendidikan Guru Sekolah Dasar',
            'Bahasa Inggris',
            'Bahasa Indonesia',
            'Matematika',
            'Fisika',
            'Kimia',
            'Biologi'
        ];

        $sekolahList = [
            'SMK Negeri 1 Jakarta',
            'SMK Negeri 2 Jakarta',
            'SMK Negeri 1 Bandung',
            'SMK Negeri 2 Bandung',
            'SMK Negeri 1 Surabaya',
            'SMK Negeri 2 Surabaya',
            'SMK Negeri 1 Yogyakarta',
            'SMK Negeri 2 Yogyakarta',
            'SMK Negeri 1 Semarang',
            'SMK Negeri 1 Malang',
            'SMK Negeri 2 Malang',
            'SMK Negeri 1 Solo',
            'SMK Negeri 1 Medan',
            'SMK Negeri 1 Makassar',
            'SMK Negeri 1 Denpasar',
            'SMK Telkom Jakarta',
            'SMK Telkom Bandung',
            'SMK Telkom Malang',
            'SMK Multimedia Nusantara',
            'SMK Bina Nusantara',
            'SMK Prakarya Internasional',
            'SMK Al-Azhar Jakarta',
            'SMK Santa Ursula Jakarta',
            'SMK Penerbangan Bandung',
            'SMA Negeri 1 Jakarta',
            'SMA Negeri 3 Jakarta',
            'SMA Negeri 8 Jakarta',
            'SMA Negeri 1 Bandung',
            'SMA Negeri 3 Bandung',
            'SMA Negeri 1 Surabaya',
            'SMA Negeri 2 Surabaya',
            'SMA Negeri 1 Yogyakarta',
            'SMA Negeri 1 Semarang',
            'SMA Negeri 1 Malang',
            'SMA Negeri 3 Malang',
            'SMA Negeri 1 Solo',
            'SMA Negeri 1 Medan',
            'SMA Negeri 1 Makassar',
            'SMA Taruna Nusantara',
            'SMA Labschool Jakarta',
            'SMA Al-Azhar Jakarta',
            'SMA Santa Ursula Jakarta',
            'SMA Kanisius Jakarta',
            'SMA BPK Penabur Jakarta',
            'Universitas Indonesia',
            'Universitas Gadjah Mada',
            'Institut Teknologi Bandung',
            'Institut Teknologi Sepuluh Nopember',
            'Universitas Airlangga',
            'Universitas Diponegoro',
            'Universitas Brawijaya',
            'Universitas Sebelas Maret',
            'Universitas Padjadjaran',
            'Universitas Hasanuddin',
            'Universitas Bina Nusantara',
            'Universitas Pelita Harapan',
            'Universitas Tarumanagara',
            'Universitas Trisakti',
            'Universitas Atmajaya Jakarta',
            'Institut Teknologi Telkom Purwokerto',
            'Universitas Telkom',
            'Universitas Multimedia Nusantara',
            'Universitas Ciputra',
            'Politeknik Negeri Jakarta',
            'Politeknik Negeri Bandung',
            'Politeknik Negeri Malang'
        ];

        $lowongans = Lowongan::all();

        foreach ($lowongans as $lowongan) {
            for ($i = 0; $i < 10; $i++) {
                $user = User::create([
                    'id' => Str::uuid(),
                    'nama' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'telepon' => $this->generateRandomPhoneNumber(),
                    'password' => bcrypt('password'),
                ]);

                $user->assignRole('peserta');

                $peserta = Peserta::create([
                    'id_user' => $user->id,
                    'jurusan' => $faker->randomElement($jurusanList),
                    'sekolah' => $faker->randomElement($sekolahList),
                    'nomor_identitas' => $faker->numerify('############'), 
                    'tempat_lahir' => $faker->city,
                    'tanggal_lahir' => $faker->date(),
                    'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                    'alamat' => $faker->address,
                ]);

                $mulai = Carbon::now()->addDays(rand(1, 30)); // tanggal mulai 1–30 hari ke depan
                $selesai = (clone $mulai)->addMonths(rand(3, 6));

                $magang = Magang::create([
                    'id_peserta' => $peserta->id,
                    'id_lowongan' => $lowongan->id,
                    'status' => 'menunggu',
                    'mulai' => $mulai,
                    'selesai' => $selesai,
                ]);

                $files = [
                    'profile' => 'profile',
                    'cv' => 'cv',
                    'surat_pernyataan_diri' => 'surat_pernyataan_diri',
                ];

                foreach ($files as $key => $type) {
                    $filePath = public_path("seeders/images/{$key}.jpg");

                    if ($key === 'profile' || $key === 'cv') {
                        $filePath = public_path("seeders/images/{$key}.jpg");
                    } else {
                        $filePath = public_path("seeders/images/{$key}.pdf");
                    }

                    if (file_exists($filePath)) {
                        Log::info("Processing file: {$key} with type: {$type} for Peserta");

                        try {
                            if ($key === 'surat_pernyataan_diri') {
                                $foto = Foto::uploadFoto($filePath, $magang->id, $type, 'magang');
                            } else {
                                $foto = Foto::uploadFoto($filePath, $peserta->id, $type, 'peserta');
                            }

                            Log::info("File processed successfully", ['foto' => $foto]);
                        } catch (\Exception $e) {
                            Log::error("Failed to process {$key} for Magang {$magang->id}", [
                                'error' => $e->getMessage(),
                                'trace' => $e->getTraceAsString()
                            ]);
                        }
                    } else {
                        Log::warning("File {$key} does not exist for Magang {$magang->id}.");
                    }
                }

            }
        }
    }

    private function generateRandomPhoneNumber()
    {
        $phoneNumber = '08';

        for ($i = 0; $i < 10; $i++) {
            $phoneNumber .= mt_rand(0, 9);
        }

        return $phoneNumber;
    }
}
