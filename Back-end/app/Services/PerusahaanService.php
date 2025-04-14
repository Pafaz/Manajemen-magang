<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\PerusahaanResource;
use App\Http\Resources\PesertaDetailResource;
use App\Http\Resources\PesertaResource;
use App\Interfaces\PerusahaanInterface;
use App\Interfaces\PesertaInterface;
use Symfony\Component\HttpFoundation\Response;

class PerusahaanService 
{
    private PerusahaanInterface $PerusahaanInterface;

    public function __construct(PerusahaanInterface $PerusahaanInterface)
    {
        $this->PerusahaanInterface = $PerusahaanInterface;
    }

    public function getAllPerusahaan()
    {
        $data = $this->PerusahaanInterface->getAll();
        return Api::response(
            PerusahaanResource::collection($data),
            'Perusahaan Fetched Successfully', 
        );
    }

    public function getPerusahaanById($id){
        $Perusahaan = $this->PerusahaanInterface->find($id);
        return Api::response(
            PerusahaanResource::make($Perusahaan),
            'Perusahaan Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function createPerusahaan(array $data)
    {
        $Perusahaan = $this->PerusahaanInterface->create($data);
        return Api::response(
            PerusahaanResource::make($Perusahaan),
            'Perusahaan Created Successfully',
            Response::HTTP_CREATED
        );
    }

    public function updatePerusahaan(array $data, $id)
    {
        $Perusahaan = $this->PerusahaanInterface->update($id, $data);
        return Api::response(
            PerusahaanResource::make($Perusahaan),
            'Perusahaan Updated Successfully',
            Response::HTTP_OK
        );
    }

    public function deletePerusahaan( $id)
    {
        $this->PerusahaanInterface->delete($id);
        return Api::response(
            null,
            'Perusahaan Deleted Successfully',
            Response::HTTP_OK
        );
    }

}