<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\PesertaResource;
use App\Interfaces\PesertaInterface;
use Symfony\Component\HttpFoundation\Response;

class PesertaService 
{
    private PesertaInterface $pesertaInterface;

    public function __construct(PesertaInterface $pesertaInterface)
    {
        $this->pesertaInterface = $pesertaInterface;
    }

    public function getAllPeserta()
    {
        $data = $this->pesertaInterface->getAll();
        return Api::response(
            PesertaResource::collection($data),
            'Peserta Fetched Successfully', 
        );
    }

    public function createPeserta(array $data)
    {
        $peserta = $this->pesertaInterface->create([$data]);
        return Api::response(
            PesertaResource::make($peserta),
            'Peserta created successfully',
            Response::HTTP_CREATED
        );
    }

}