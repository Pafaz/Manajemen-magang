<?php

namespace App\Services;

use App\Helpers\Api;
use App\Interfaces\CabangInterface;
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

    public function createCabang(array $data)
    {
        try {

        $perusahaan = $this->perusahaanInterface->findByUser(auth('sanctum')->user()->id);
        $jumlahCabang = $this->cabangInterface->getCabangByPerusahaanId($perusahaan->id);
        if ($jumlahCabang >= 1) {
            throw new \Exception("Anda sudah mencapai limit cabang. Silakan upgrade ke premium!");
        }
        
        $data['id_perusahaan'] = $perusahaan->id;
        // dd($data);
        $cabang = $this->cabangInterface->create($data);
        // $cabang->perusahaan()->attach($perusahaan->id);

        return Api::response(
            CabangResource::make($cabang),
            'Cabang Created Successfully',
            Response::HTTP_CREATED
        );

        }catch (\Exception $e) {
            return Api::response(
                null,
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
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
        $this->cabangInterface->delete($id);
        return Api::response(
            null,
            'Cabang Deleted Successfully',
            Response::HTTP_OK
        );
    }
}