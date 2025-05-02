<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\LowonganResource;
use App\Interfaces\LowonganInterface;

class LowonganService
{
    private LowonganInterface $lowonganInterface;
    public function __construct(LowonganInterface $lowonganInterface)
    {
        $this->lowonganInterface = $lowonganInterface;
    }

    public function getAllLowongan()
    {
        $data = $this->lowonganInterface->getAll($id = null);
        return Api::response(
            LowonganResource::collection($data),
            'Lowongan Berhasil ditampilkan'
        );
    }

    public function getLowonganById($id)
    {
        $data = $this->lowonganInterface->find($id);
        return Api::response(
            LowonganResource::collection($data),
            'Lowongan Berhasil ditampilkan'
        );
    }


    public function createLowongan() {}

    public function updateLowongan() {}

    public function deleteLowongan() {}
}