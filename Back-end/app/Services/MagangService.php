<?php

namespace App\Services;

use App\Helpers\Api;
use App\Interfaces\MagangInterface;
use App\Http\Resources\MagangResource;
use App\Http\Resources\JurusanResource;
use Symfony\Component\HttpFoundation\Response;

class MagangService
{
    private MagangInterface $MagangInterface;
    private FotoService $foto;

    public function __construct(MagangInterface $MagangInterface, FotoService $foto)
    {
        $this->MagangInterface = $MagangInterface;
        $this->foto = $foto;
    }

    public function getAllMagang()
    {
        $data = $this->MagangInterface->getAll();
        return Api::response(
            MagangResource::collection($data),
            'Magang Fetched Successfully', 
        );
    }

    public function applyMagang(array $data)
    {
        $magang = $this->MagangInterface->create([
            
        ]);

        $files = [
            'surat_pernyataan_diri' => 'surat_pernyataan_diri',
            'surat_pernyataan_ortu' => 'surat_pernyataan_ortu',
        ];

        foreach ($files as $key => $type) {
            if (!empty($data[$key])) {
                $this->foto->createFoto($data[$key], $perusahaan->id, $type);
            }
        }
        return Api::response(
            MagangResource::make($magang),
            'Berhasil mengajukan magang',
            Response::HTTP_CREATED
        );
    }

    public function getMagangById(int $id)
    {
        $magang = $this->MagangInterface->find($id);
        return Api::response(
            MagangResource::make($magang),
            'Magang fetched successfully',
            Response::HTTP_OK
        );
    }
}