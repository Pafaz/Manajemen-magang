<?php

namespace App\Services;

use App\Helpers\Api;
use App\Models\Cabang;
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
        $perusahaan = $this->perusahaanInterface->find($data['perusahaan_id']);
        $data['perusahaan'] = $perusahaan;
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