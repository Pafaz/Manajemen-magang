<?php

namespace App\Services;

use App\Helpers\Api;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CabangInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\CabangResource;
use Symfony\Component\HttpFoundation\Response;


class CabangService
{
    private CabangInterface $cabangInterface;
    private FotoService $foto;
    private UserInterface $userInterface;

    public function __construct(CabangInterface $cabangInterface, FotoService $foto, UserInterface $userInterface)
    {
        $this->cabangInterface = $cabangInterface;
        $this->foto = $foto;
        $this->userInterface = $userInterface;
    }

    public function getCabang($id = null, $id_perusahaan = null)
    {
        if ($id_perusahaan == null) {
            return Api::response("anda harus melengkapi profil", 404);
        }

        $cacheKey = 'cabang_' . ($id ? $id : $id_perusahaan);

        $data = Cache::remember($cacheKey, 3600, function () use ($id, $id_perusahaan) {
            if ($id) {
                return collect([$this->cabangInterface->find($id, $id_perusahaan)]);
            }
            return $this->cabangInterface->getCabangByPerusahaanId($id_perusahaan);
        });

        $message = $id
            ? 'Berhasil mengambil data cabang'
            : 'Berhasil mengambil semua data cabang';

        return Api::response(
            CabangResource::collection($data),
            $message,
            Response::HTTP_OK
        );
    }


    public function simpanCabang(array $data, bool $isUpdate = false, $id = null)
    {
        DB::beginTransaction();
        try {
            $user = auth('sanctum')->user();

            if (!$user->perusahaan) {
                throw new \Exception("Lengkapi profil perusahaan anda terlebih dahulu");
            }

            if (!$isUpdate && $user->perusahaan->cabang()->count() >= 1) {
                throw new \Exception("Anda sudah mencapai limit cabang. Silakan upgrade ke premium!");
            }

            $cabangData = [
                'nama' => $data['nama'] ?? null,
                'bidang_usaha' => $data['bidang_usaha'] ?? null,
                'provinsi' => $data['provinsi'] ?? null,
                'kota' => $data['kota'] ?? null,
                'id_perusahaan' => $user->perusahaan->id,
            ];

            if ($isUpdate && empty(array_filter($cabangData))) {
                throw new \Exception("Tidak ada data yang dikirim untuk diperbarui");
            }

            $cabang = $isUpdate
                ? $this->cabangInterface->update($id, array_filter($cabangData))
                : $this->cabangInterface->create(array_filter($cabangData));

            $files = [
                'logo' => 'logo',
                'profil_cover' => 'profil_cover',
            ];

            foreach ($files as $key => $type) {
                if (!empty($data[$key])) {
                    Log::info("Processing file: {$key} with type: {$type}");
                    try {
                        $result = $this->foto->updateFoto($data[$key], $cabang->id, $type, 'cabang');
                        Log::info("File processed successfully", ['result' => $result]);
                    } catch (\Exception $e) {
                        Log::error("Failed to process {$key}", [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                }
            }

            DB::commit();

            return Api::response(
                new CabangResource($cabang),
                $isUpdate ? 'Cabang berhasil diperbarui' : 'Cabang berhasil dibuat',
                $isUpdate ? Response::HTTP_OK : Response::HTTP_CREATED
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Gagal membuat cabang: " . $e->getMessage());

            return Api::response(
                null,
                'Gagal membuat cabang: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }


    public function deleteCabang($id)
    {
        $user = auth('sanctum')->user();
        if (!$user->perusahaan->cabang()->where('id', $id)->exists()) {
            return Api::response(null, 'Cabang tidak valid untuk perusahaan ini', Response::HTTP_FORBIDDEN);
        }

        $this->cabangInterface->delete($id);
        return Api::response(
            null,
            'Berhasil menghapus cabang',
            Response::HTTP_OK
        );
    }

    public function setCabangAktif(int $idCabang)
    {
        $user = auth('sanctum')->user();
        if (!$user->perusahaan->cabang()->where('id', $idCabang)->exists()) {
            return Api::response(null, 'Cabang tidak valid untuk perusahaan ini', Response::HTTP_FORBIDDEN);
        }
        
        $this->userInterface->update($user->id, ['id_cabang_aktif' => $idCabang]);

        $cabang = $this->cabangInterface->find($idCabang, $user->perusahaan->id);

        return Api::response(
            CabangResource::make($cabang),
            'Berhasil akses cabang',
        );
    }
}