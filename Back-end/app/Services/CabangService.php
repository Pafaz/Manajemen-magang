<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CabangInterface;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\CabangResource;
use App\Interfaces\PerusahaanInterface;
use Symfony\Component\HttpFoundation\Response;


class CabangService
{
    private PerusahaanInterface $perusahaanInterface;
    private CabangInterface $cabangInterface;

    public function __construct(CabangInterface $cabangInterface, PerusahaanInterface $perusahaanInterface)
    {
        $this->cabangInterface = $cabangInterface;
        $this->perusahaanInterface = $perusahaanInterface;
    }

    public function getAllCabang()
    {
        $data = $this->cabangInterface->getAll();
        return Api::response(
            CabangResource::collection($data),
            'Cabang Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function getCabangByPerusahaanId($id)
    {
        return $this->cabangInterface->getCabangByPerusahaanId($id);
    }

    public function simpanCabang(array $data, bool $isUpdate = false, $id = null)
    {
        DB::beginTransaction();

        try {
            $user = auth('sanctum')->user();

            if (!$user->perusahaan) {
                throw new \Exception("Perusahaan belum terdaftar");
            }

            if (!$isUpdate && $user->perusahaan->cabang()->count() >= 1) {
                throw new \Exception("Anda sudah mencapai limit cabang. Silakan upgrade ke premium!");
            }

            
            $cabangData = [
                'bidang_usaha' => $data['bidang_usaha'] ?? null,
                'provinsi' => $data['provinsi'] ?? null,
                'kota' => $data['kota'] ?? null,
                'instagram' => $data['instagram'] ?? null,
                'linkedin' => $data['linkedin'] ?? null,
                'website' => $data['website'] ?? null,
                'id_perusahaan' => $user->perusahaan->id,
            ];

            if ($isUpdate && empty(array_filter($cabangData))) {
                throw new \Exception("Tidak ada data yang dikirim untuk diperbarui");
            }
            
            $cabang = $isUpdate
                ? $this->cabangInterface->update($id, array_filter($cabangData))
                : $this->cabangInterface->create(array_filter($cabangData));

            DB::commit();

            return Api::response(
                new CabangResource($cabang),
                $isUpdate ? 'Cabang berhasil diperbarui' : 'Cabang berhasil dibuat',
                $isUpdate ? Response::HTTP_OK : Response::HTTP_CREATED
            );

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Gagal menyimpan cabang: " . $e->getMessage());

            return Api::response(
                null,
                'Gagal menyimpan cabang'. $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    // public function createCabang(array $data)
    // {
    //     try {
    //     $user = auth('sanctum')->user();
    //         // dd($user->perusahaan->id);
    //     if ($user->perusahaan->cabang()->count() >= 1) {
    //         throw new \Exception("Anda sudah mencapai limit cabang. Silakan upgrade ke premium!");
    //     }
        
    //     // $data['id_perusahaan'] = $user->perusahaan->id;
    //     $cabang = $this->cabangInterface->create([
    //         'bidang_usaha' => $data['bidang_usaha'],
    //         'provinsi' => $data['provinsi'],
    //         'kota' => $data['kota'],
    //         'id_perusahaan' => $user->perusahaan->id,
    //         'instagram' => $data['instagram'],
    //         'linkedin' => $data['linkedin'],
    //         'website' => $data['website'],
    //     ]);

    //     return Api::response(
    //         CabangResource::make($cabang),
    //         'Cabang Created Successfully',
    //         Response::HTTP_CREATED
    //     );

    //     }catch (\Exception $e) {
    //         return Api::response(
    //             null,
    //             $e->getMessage(),
    //             Response::HTTP_INTERNAL_SERVER_ERROR
    //         );
    //     }
    // }

    // public function updateCabang(array $data, $id)
    // {
    //     $cabang = $this->cabangInterface->update($id, $data);
    //     return Api::response(
    //         CabangResource::make($cabang),
    //         'Cabang Updated Successfully',
    //         Response::HTTP_OK
    //     );
    // }

    public function deleteCabang($id)
    {
        $this->cabangInterface->delete($id);
        return Api::response(
            null,
            'Cabang Deleted Successfully',
            Response::HTTP_OK
        );
    }
}