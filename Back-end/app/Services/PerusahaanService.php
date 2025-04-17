<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Support\Facades\Log;
use App\Interfaces\PesertaInterface;
use App\Http\Resources\PesertaResource;
use App\Interfaces\PerusahaanInterface;
use Illuminate\Database\QueryException;
use App\Http\Resources\PerusahaanResource;
use App\Http\Resources\PesertaDetailResource;
use App\Interfaces\FotoInterface;
use Symfony\Component\HttpFoundation\Response;

class PerusahaanService 
{
    private PerusahaanInterface $PerusahaanInterface;
    private FotoService $foto;

    public function __construct(PerusahaanInterface $PerusahaanInterface, FotoService $foto)
    {
        $this->PerusahaanInterface = $PerusahaanInterface;
        $this->foto = $foto;
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
        try {
            $perusahaan = $this->PerusahaanInterface->create($data);

            $files = [
                'logo' => 'logo',
                'npwp' => 'npwp',
                'surat_legalitas' => 'surat_legalitas',
            ];
            foreach ($files as $key => $tipe) {
                if (!empty($data[$key])) {
                    $this->foto->createFoto($data[$key], $perusahaan->id, $tipe);
                }
            }

            return Api::response(
                PerusahaanResource::make($perusahaan),
                'Perusahaan Created Successfully',
                Response::HTTP_CREATED
            );
    
        } catch (QueryException $e) {
            Log::error('DB Error creating Perusahaan: '.$e->getMessage());
            return Api::response(
                null,
                'Registrasi Perusahaan gagal: '.$e->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        }
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