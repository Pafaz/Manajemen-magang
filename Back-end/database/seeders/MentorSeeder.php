<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Divisi;
use App\Models\Foto;
use App\Models\Mentor;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Faker\Factory as Faker;

class MentorSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $divisis = Divisi::all();

        foreach ($divisis as $divisi) {
            $user = User::create([
                'id' => Str::uuid(),
                'nama' => $faker->name,
                'email' => $faker->email,
                'telepon'=> $this->generateRandomPhoneNumber(),
                'password' => bcrypt('password'),
                'id_cabang_aktif' => $divisi->id_cabang,
            ]);

            $user->assignRole('mentor');

            $mentor = Mentor::create([
                'id' => Str::uuid(),
                'id_user' => $user->id,
                'id_divisi' => $divisi->id,
                'id_cabang' => $divisi->id_cabang,
            ]);

            $files = [
                'profile' => 'profile',
                'cover' => 'cover',
            ];

            foreach ($files as $key => $type) {
                $filePath = public_path("seeders/images/{$key}.jpg");  // Pastikan gambar ada di folder ini

                if (file_exists($filePath)) {
                    // Memanggil fungsi updateFoto untuk menyimpan gambar
                    Log::info("Processing file: {$key} with type: {$type} for Mentor");
                    try {
                        $foto = Foto::uploadFoto($filePath, $mentor->id, $type, 'mentor');
                        Log::info("File processed successfully", ['foto' => $foto]);
                    } catch (\Exception $e) {
                        Log::error("Failed to process {$key} for Mentor {$mentor->id}", [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                } else {
                    Log::warning("File {$key} does not exist for Mentor {$mentor->id}.");
                }
            }
        }
    }

    private function generateRandomPhoneNumber() {
        $phoneNumber = '08';

        for ($i = 0; $i < 10; $i++) {
            $phoneNumber .= mt_rand(0, 9);
        }

        return $phoneNumber;
    }
}
