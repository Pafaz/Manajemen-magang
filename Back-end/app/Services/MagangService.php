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

    public function __construct(MagangInterface $MagangInterface)
    {
        $this->MagangInterface = $MagangInterface;
    }

    public function getMagang()
    {
        $data = $this->MagangInterface->getAll();
        return Api::response(
            JurusanResource::collection($data),
            'Jurusan Fetched Successfully', 
        );
    }

    public function createMagang(array $data)
    {
        $magang = $this->MagangInterface->create($data);
        return Api::response(
            MagangResource::make($magang),
            'Jurusan created successfully',
            Response::HTTP_CREATED
        );
    }

    public function getMagangById(int $id)
    {
        $magang = $this->MagangInterface->find($id);
        return Api::response(
            MagangResource::make($magang),
            'Jurusan fetched successfully',
            Response::HTTP_OK
        );
    }
}