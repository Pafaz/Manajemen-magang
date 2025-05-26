<?php

namespace App\Services;

use App\Helpers\Api;
use App\Services\FotoService;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\DB;
use App\Interfaces\MagangInterface;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\MitraResource;
use App\Interfaces\PerusahaanInterface;
use Illuminate\Database\QueryException;
use App\Http\Resources\PerusahaanResource;
use App\Http\Resources\MitraDetailResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\PerusahaanDetailResource;

class PerusahaanService
{
    private PerusahaanInterface $PerusahaanInterface;
    private FotoService $foto;
    private UserInterface $userInterface;
    private MagangInterface $magangInterface;

    public function __construct(PerusahaanInterface $PerusahaanInterface, FotoService $foto, UserInterface $userInterface, MagangInterface $magangInterface)
    {
        $this->PerusahaanInterface = $PerusahaanInterface;
        $this->foto = $foto;
        $this->userInterface = $userInterface;
        $this->magangInterface = $magangInterface;
    }

    public function getPerusahaan()
    {   
        $data = $this->PerusahaanInterface->getAll();
        
        return Api::response(
            PerusahaanResource::collection($data),
            'Berhasil mengambil data perusahaan',
        );
    }

    public function getMitra()
    {
        $data = $this->PerusahaanInterface->getAll();

        return Api::response(
            MitraResource::collection($data),
            'Berhasil mengambil data perusahaan',
        );
    }

    public function showMitra($id_mitra)
    {
        $total_peserta = $this->magangInterface->countPesertaByPerusahaan($id_mitra);
        $data = $this->PerusahaanInterface->find($id_mitra);    
        $data['total_peserta'] = $total_peserta;
        return Api::response(
            MitraDetailResource::make($data),
            'Berhasil mengambil data perusahaan',
        );
    }

    public function isCompleteProfil()
    {
        if (!auth('sanctum')->user()->perusahaan) {
            return Api::response(
                'false',
                'Perusahaan belum melengkapi profil',
                Response::HTTP_OK
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
                'profil_cover' => 'profil_cover',
            ];
            
            foreach ($files as $key => $type) {
                if (!empty($data[$key])) {
                    $this->foto->updateFoto($data[$key], $perusahaan->id, $type, 'perusahaan');
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
