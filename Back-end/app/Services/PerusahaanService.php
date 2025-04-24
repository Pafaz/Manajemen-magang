<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\FotoResource;
use App\Http\Resources\PerusahaanDetailResource;
use App\Services\FotoService;
use App\Interfaces\FotoInterface;
use Illuminate\Support\Facades\Log;
use App\Interfaces\PerusahaanInterface;
use Illuminate\Database\QueryException;
use App\Http\Resources\PerusahaanResource;
use App\Interfaces\UserInterface;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;


class PerusahaanService
{
    private PerusahaanInterface $PerusahaanInterface;
    private FotoService $foto;
    private UserInterface $userInterface;

    public function __construct(PerusahaanInterface $PerusahaanInterface, FotoService $foto, UserInterface $userInterface)
    {
        $this->PerusahaanInterface = $PerusahaanInterface;
        $this->foto = $foto;
        $this->userInterface = $userInterface;
    }

    public function getAllPerusahaan()
    {
        $data = $this->PerusahaanInterface->getAll();
        return Api::response(
            PerusahaanResource::collection($data),
            'Berhasil mengambil data perusahaan',
        );
    }

    public function getPerusahaan($id)
    {
        $data = $this->PerusahaanInterface->find($id);
        return Api::response(
            PerusahaanDetailResource::make($data),
            'Berhasil mengambil data perusahaan',
        );
    }

    public function getPerusahaanByAuth()
    {
        $data = $this->PerusahaanInterface->findByUser(auth('sanctum')->user()->id);
        return Api::response(
            PerusahaanDetailResource::make($data),
            'Berhasil mengambil data perusahaan',
        );
    }

    public function simpanProfil(array $data, bool $isUpdate = false)
    {
        DB::beginTransaction();

        try {
            $user = auth('sanctum')->user();
            
            if ($isUpdate && !$user->perusahaan) {
                throw new \Exception('Perusahaan belum terdaftar');
            }
            $userData = array_filter([
                'name' => $data['nama'] ?? null,
                'telepon' => $data['telepon'] ?? null,
                'email' => $data['email'] ?? null,
            ]);
            if (!empty($userData)) {
                $this->userInterface->update($user->id, $userData);
            }

            $perusahaan = $isUpdate
                ? $this->PerusahaanInterface->update($user->perusahaan->id, array_filter($data))
                : $this->PerusahaanInterface->create($data);

            $files = [
                'logo' => 'profile',
                'npwp' => 'npwp',
                'surat_legalitas' => 'surat_legalitas',
            ];

            foreach ($files as $key => $type) {
                if (!empty($data[$key])) {
                    if ($isUpdate) {
                        $this->foto->updateFoto($data[$key], $perusahaan->id, $type);
                    } else {
                        $this->foto->createFoto($data[$key], $perusahaan->id, $type);
                    }
                }
            }

            DB::commit();
            return $perusahaan;
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Gagal menyimpan profil perusahaan: " . $e->getMessage());
            throw $e;
        }
    }

    // public function LengkapiProfilPerusahaan(array $data)
    // {
    //     try {
    //         $user = auth('sanctum')->user();

    //         if ($user->perusahaan) {
    //             return Api::response(null, 'Perusahaan sudah terdaftar', Response::HTTP_BAD_REQUEST);
    //         }

    //         // Gunakan transaction untuk memastikan integritas data
    //         DB::beginTransaction();

    //         $this->userInterface->update($user->id, [
    //             'name' => $data['nama'],
    //             'telepon' => $data['telepon'],
    //         ]);

    //         $perusahaan = $this->PerusahaanInterface->create($data);

    //         $files = [
    //             'logo' => 'profile',
    //             'npwp' => 'npwp',
    //             'surat_legalitas' => 'surat_legalitas',
    //         ];

    //         foreach ($files as $key => $tipe) {
    //             if (!empty($data[$key])) {
    //                 $this->foto->createFoto($data[$key], $perusahaan->id, $tipe);
    //             }
    //         }

    //         DB::commit();

    //         return Api::response(
    //             PerusahaanResource::make($perusahaan),
    //             'Berhasil melengkapi profil perusahaan',
    //             Response::HTTP_CREATED
    //         );
    //     } catch (QueryException $e) {
    //         DB::rollBack();
    //         Log::error('DB Error melengkapi profil perusahaan: ' . $e->getMessage());
    //         return Api::response(
    //             null,
    //             'Terjadi kesalahan saat melengkapi profil perusahaan: ' . $e->getMessage(),
    //             Response::HTTP_BAD_REQUEST
    //         );
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         Log::error('Error melengkapi profil perusahaan: ' . $e->getMessage());
    //         return Api::response(
    //             null,
    //             'Terjadi kesalahan saat melengkapi profil perusahaan.',
    //             Response::HTTP_INTERNAL_SERVER_ERROR
    //         );
    //     }
    // }

    // public function updateProfilPerusahaan(array $data, $id)
    // {
    //     $user = auth('sanctum')->user();

    //     $userData = array_filter([
    //         'name' => $data['nama'] ?? null,
    //         'telepon' => $data['telepon'] ?? null,
    //         'email' => $data['email'] ?? null,
    //     ]);

    //     if (!empty($userData)) {
    //         $this->userInterface->update($user->id, $userData);
    //     }

    //     $Perusahaan = $this->PerusahaanInterface->update($id, array_filter($data));

    //     $files = [
    //         'logo' => 'profile',
    //         'npwp' => 'npwp',
    //         'surat_legalitas' => 'surat_legalitas',
    //     ];
        
    //     foreach ($files as $key => $tipe) {
    //         if (!empty($data[$key]) && $data[$key]) {
    //             $this->foto->updateFoto($data[$key], $Perusahaan->id, $tipe);
    //         }
    //     }
        
    //     return Api::response(
    //         PerusahaanResource::make($Perusahaan),
    //         'Berhasil memperbarui profil perusahaan',
    //         Response::HTTP_OK
    //     );
    // }


    public function deletePerusahaan($id)
    {
        $this->PerusahaanInterface->delete($id);
        return Api::response(
            null,
            'Berhasil menghapus data perusahaan',
            Response::HTTP_OK
        );
    }
}
