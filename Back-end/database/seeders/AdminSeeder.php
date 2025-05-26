<?php
namespace Database\Seeders;

use App\Models\Foto;
use App\Models\User;
use App\Models\Cabang;
use Illuminate\Support\Str;
use App\Models\Admin_cabang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $cabangs = Cabang::all();

        foreach ($cabangs as $cabang) {
            $user = User::create([
                'id' => Str::uuid(),
                'nama' => 'Admin ' . $cabang->nama,
                'email' => 'admin_' . strtolower($cabang->nama) . '@hummatech.com',
                'id_cabang_aktif' => $cabang->id,
                'telepon' => $this->generateRandomPhoneNumber(),
                'password' => bcrypt('password'),
            ]);

            $user->assignRole('admin');

            $admin = Admin_cabang::create([
                'id' => Str::uuid(),
                'id_cabang' => $cabang->id,
                'id_user' => $user->id,
            ]);

            $files = [
                'profile' => 'profile',
                'cover' => 'cover',
            ];

            foreach ($files as $key => $type) {
                $filePath = public_path("seeders/images/{$key}.jpg");

                if (file_exists($filePath)) {
                    Log::info("Processing file: {$key} with type: {$type} for admin");
                    try {
                        $foto = Foto::uploadFoto($filePath, $admin->id, $type, 'admin');
                        Log::info("File processed successfully", ['foto' => $foto]);
                    } catch (\Exception $e) {
                        Log::error("Failed to process {$key} for admin {$admin->id}", [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                } else {
                    Log::warning("File {$key} does not exist for admin {$admin->id}.");
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
