<?php
namespace Database\Seeders;

use App\Models\Lowongan;
use App\Models\Peserta;
use App\Models\User;
use App\Models\Foto;
use App\Models\Magang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;

class PesertaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $lowongans = Lowongan::all();

        foreach ($lowongans as $lowongan) {
            for ($i = 0; $i < 50; $i++) {
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
                    'jurusan' => $faker->word,
                    'sekolah' => $faker->company,
                    'nomor_identitas' => Str::random(12), 
                    'tempat_lahir' => $faker->city,
                    'tanggal_lahir' => $faker->date(),
                    'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                    'alamat' => $faker->address,
                ]);

                $magang = Magang::create([
                    'id_peserta' => $peserta->id,
                    'id_lowongan' => $lowongan->id,
                    'status' => 'menunggu',
                    'mulai' => $faker->date(),
                    'selesai' => $faker->date(),
                ]);

                $files = [
                    'profile' => 'profile',
                    'cv' => 'cv',
                    'surat_pernyataan_diri' => 'surat_pernyataan_diri',
                ];

                foreach ($files as $key => $type) {
                    $filePath = public_path("seeders/images/{$key}.jpg");

                    if ($key === 'profile') {
                        $filePath = public_path("seeders/images/{$key}.jpg");
                    } else {
                        $filePath = public_path("seeders/images/{$key}.pdf");
                    }

                    if (file_exists($filePath)) {
                        Log::info("Processing file: {$key} with type: {$type} for Peserta");
                        try {
                            $foto = Foto::uploadFoto($filePath, $magang->id, $type, 'magang');
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
