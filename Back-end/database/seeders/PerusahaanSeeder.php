<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Cabang;
use App\Models\Divisi;
use App\Models\Kategori;
use App\Models\Lowongan;
use App\Models\Jam_Kantor;
use App\Models\Perusahaan;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Divisi_Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perusahaan = User::create([
            'id' => Str::uuid(),
            'nama' => 'PT. Hummatech Indonesia',
            'email' => 'pkl@hummatech.com',
            'telepon'=> '081933301405',
            'password' => bcrypt('password'),
        ]);

        $perusahaan->assignRole('perusahaan');

        $perusahaan_record = Perusahaan::create([
            'id'=> Str::uuid(),
            'id_user' => $perusahaan->id,
            'deskripsi' => 'Berdiri sejak tahun 2022 dan bergerak di bidang software development',
            'provinsi'=> 'Jawa Timur',
            'kota' => 'Malang',
            'kecamatan' => 'Karangploso',
            'alamat' => 'Jalan Ikan Hiu No.13',
            'kode_pos' => '68417',
            'website' => 'https://www.hummatech.com',
            'is_premium' => true,
            'is_active' => true,
            'cabang_limit' => 3,
            'nama_penanggung_jawab' => 'Afif CS',
            'nomor_penanggung_jawab' => '087773827374',
            'jabatan_penanggung_jawab' => 'Direktur',
            'email_penanggung_jawab' => 'afifhrd@gmail.com',
            'tanggal_berdiri' => '2025-01-06',
        ]);

        $files = [
            'profile' => 'profile', // Gambar logo perusahaan
            'profil_cover' => 'profil_cover', // Gambar cover profil perusahaan
        ];

        foreach ($files as $key => $type) {
            $filePath = public_path("seeders/images/{$key}.jpg");  // Pastikan gambar ada di folder ini

            if (file_exists($filePath)) {
                // Memanggil fungsi uploadFoto untuk menyimpan gambar perusahaan
                Log::info("Processing file: {$key} with type: {$type}");
                try {
                    $foto = \App\Models\Foto::uploadFoto($filePath, $perusahaan->id, $type, 'perusahaan');
                    Log::info("File processed successfully", ['foto' => $foto]);
                } catch (\Exception $e) {
                    Log::error("Failed to process {$key}", [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            } else {
                Log::warning("File {$key} does not exist in the expected directory.");
            }
        }

        $cabangs = [
            'Malang', 'Jember', 'Banyuwangi'
        ];

        foreach ($cabangs as $kota) {
            $cabang = Cabang::create([
                'id_perusahaan' => $perusahaan_record->id,
                'nama'=> 'PT. Hummatech ' . $kota,
                'bidang_usaha' => 'Software Development',
                'provinsi' => 'Jawa Timur',
                'kota' => $kota,
            ]);

            $files = [
                'profile' => 'profile', // Gambar logo cabang
                'profil_cover' => 'profil_cover', // Gambar cover profil cabang
            ];

            foreach ($files as $key => $type) {
                $filePath = public_path("seeders/images/{$key}.jpg"); // Pastikan gambar ada di folder ini

                if (file_exists($filePath)) {
                    Log::info("Processing file: {$key} with type: {$type} for Cabang");
                    try {
                        $foto = \App\Models\Foto::uploadFoto($filePath, $cabang->id, $type, 'cabang');
                        Log::info("File processed successfully", ['foto' => $foto]);
                    } catch (\Exception $e) {
                        Log::error("Failed to process {$key} for Cabang {$cabang->nama}", [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                } else {
                    Log::warning("File {$key} does not exist for Cabang {$cabang->nama}.");
                }
            }

            $divisiNames = ['Fullstack web developer', 'UI/UX', 'Mobile developer'];

            foreach ($divisiNames as $divisiName) {
                $divisi = Divisi::create([
                    'nama' => $divisiName,
                    'id_cabang' => $cabang->id,
                    'created_at' => Carbon::now(),
                    'updated_at'=> Carbon::now(),
                ]);

                $kategoriNames = ['Pengenalan', 'Solo Projek', 'Mini Projek', 'Big Projek'];

                foreach ($kategoriNames as $key => $kategoriName) {
                    $kategori = Kategori::firstOrCreate(['nama' => $kategoriName]);

                    Divisi_Kategori::create([
                        'id_divisi' => $divisi->id,
                        'id_kategori' => $kategori->id,
                        'urutan' => $key + 1
                    ]);
                }

                Lowongan::create([
                    'id_perusahaan' => $perusahaan_record->id,
                    'id_cabang' => $cabang->id,
                    'id_divisi' => $divisi->id,
                    'tanggal_mulai' => '2025-01-06',
                    'tanggal_selesai' => '2025-04-06',
                    'max_kuota' => 100,
                    'requirement' => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.",
                    'jobdesc'=> "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.",
                ]);
            }

            $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
            $jamKantorData = [];

        foreach ($days as $day) {
            $jamKantorData[] = [
                'id_cabang' => $cabang->id,
                'hari' => $day,
                'awal_masuk' => '07:00',
                'akhir_masuk' => '08:00',
                'awal_istirahat' => '12:00',
                'akhir_istirahat' => '13:00',
                'awal_kembali' => '12:45',
                'akhir_kembali' => '13:00',
                'awal_pulang' => '16:00',
                'akhir_pulang' => '17:00',
                'status' => true,
            ];
        }

        Jam_Kantor::insert($jamKantorData);
        }
    }
}
