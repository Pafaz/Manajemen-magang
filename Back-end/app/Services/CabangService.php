<?php

namespace App\Services;

use App\Helpers\Api;
use App\Models\Cabang;
use App\Models\Perusahaan;
use Illuminate\Http\Response;
use App\Interfaces\CabangInterface;
use App\Http\Resources\CabangResource;
use App\Interfaces\PerusahaanInterface;

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
        );
    }

    public function getCabangByPerusahaanId($id)
    {
        return $this->cabangInterface->getCabangByPerusahaanId($id);
    }

    public function createCabang(array $data)
    {
        if (!Perusahaan::where('id', $data['id_perusahaan'])->exists()) {
            throw new \Exception("ID perusahaan tidak ditemukan.");
        }
        $jumlahCabang = $this->cabangInterface->getCabangByPerusahaanId($data['id_perusahaan']);
        if ($jumlahCabang >= 1) {
            throw new \Exception("Anda sudah mencapai limit cabang. Silakan upgrade ke premium!");
        }

        $cabang = $this->cabangInterface->create($data);

        return Api::response(
            CabangResource::make($cabang),
            'Cabang Created Successfully',
            Response::HTTP_CREATED
        );
    }

    public function updateCabang(array $data, $id)
    {
        $cabang = $this->cabangInterface->update($id, $data);
        return Api::response(
            CabangResource::make($cabang),
            'Cabang Updated Successfully',
            Response::HTTP_OK
        );
    }

    public function deleteCabang($id)
    {
        $cabang = $this->cabangInterface->delete($id);
        return Api::response(
            null,
            'Cabang Deleted Successfully',
            Response::HTTP_OK
        );
    }
}