<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\JurusanResource;
use App\Http\Resources\SchoolResource;
use App\Interfaces\JurusanInterface;
use App\Interfaces\SekolahInterface;
use Symfony\Component\HttpFoundation\Response;

class JurusanService 
{
    private JurusanInterface $JurusanInterface;

    public function __construct(JurusanInterface $JurusanInterface)
    {
        $this->JurusanInterface = $JurusanInterface;
    }

    public function getMajors()
    {
        $data = $this->JurusanInterface->getAll();
        return Api::response(
            JurusanResource::collection($data),
            'Jurusan Fetched Successfully', 
        );
    }

    public function createMajor(array $data)
    {
        $jurusan = $this->JurusanInterface->create($data);
        return Api::response(
            JurusanResource::make($jurusan),
            'Jurusan created successfully',
            Response::HTTP_CREATED
        );
    }

    public function updateMajor(int $id, array $data)
    {
        $jurusan = $this->JurusanInterface->update($id, $data);
        return Api::response(
            JurusanResource::make($jurusan),
            'Jurusan updated successfully',
            Response::HTTP_OK
        );
    }

    public function deleteMajor(int $id)
    {
        $this->JurusanInterface->delete($id);
        return Api::response(
            null,
            'Jurusan deleted successfully',
            Response::HTTP_OK
        );
    }

    public function getMajorById(int $id)
    {
        $jurusan = $this->JurusanInterface->find($id);
        return Api::response(
            JurusanResource::make($jurusan),
            'Jurusan fetched successfully',
            Response::HTTP_OK
        );
    }
}