<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\PerusahaanDetailResource;
use App\Services\FotoService;
use Illuminate\Support\Facades\Log;
use App\Interfaces\PerusahaanInterface;
use Illuminate\Database\QueryException;
use App\Http\Resources\PerusahaanResource;
use App\Interfaces\UserInterface;
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

    public function getPerusahaan()
    {   
        $data = $this->PerusahaanInterface->getAll();
        
        return Api::response(
            PerusahaanResource::collection($data),
            'Berhasil mengambil data perusahaan',
        );
    }

    public function isCompleteProfil()
    {
        if (!auth('sanctum')->user()->perusahaan) {
            return Api::response(
                'false',
                'Perusahaan belum melengkapi profil',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return Api::response(
            'true',
            'Perusahaan telah melengkapi profil',
            Response::HTTP_OK
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
            
            if (!$isUpdate && $user->perusahaan) {
                throw new \Exception('Perusahaan sudah terdaftar');
            }
            if ($isUpdate && !$user->perusahaan) {
                throw new \Exception('Perusahaan belum terdaftar');
            }
            if($isUpdate && $data === null){
                throw new \Exception('Tidak ada data yang dikirim untuk diperbarui');
            }
            $userData = array_filter([
                'nama' => $data['nama'] ?? null,
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
                'profil_background' => 'profil_background',
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
            return Api::response(
                PerusahaanDetailResource::make($perusahaan),
                $isUpdate
                    ? 'Berhasil memperbarui profil perusahaan'
                    : 'Berhasil melengkapi profil perusahaan',
                $isUpdate ? Response::HTTP_OK : Response::HTTP_CREATED
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Gagal menyimpan profil perusahaan: " . $e->getMessage());
            throw $e;
        }
    }

    public function deletePerusahaan($id)
    {
        $this->PerusahaanInterface->delete($id);

        $id_user = $this->PerusahaanInterface->find($id)->id_user;
        
        $this->userInterface->delete($id_user);

        return Api::response(
            null,
            'Berhasil menghapus data perusahaan',
            Response::HTTP_OK
        );
    }
}
