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
            'Categories retrieved successfully', 
        );
    }

    public function createPeserta(array $data)
    {
        $category = $this->pesertaInterface->create($data);
        return Api::response(
            PesertaResource::make($category),
            'Category created successfully',
            Response::HTTP_CREATED
        );
    }

}