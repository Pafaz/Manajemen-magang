<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\SchoolResource;
use App\Interfaces\SekolahInterface;
use Symfony\Component\HttpFoundation\Response;

class SekolahService 
{
    private SekolahInterface $SekolahInterface;

    public function __construct(SekolahInterface $SekolahInterface)
    {
        $this->SekolahInterface = $SekolahInterface;
    }

    public function getSchools()
    {
        $data = $this->SekolahInterface->getAll();
        return Api::response(
            SchoolResource::collection($data),
            'School Fetched Successfully', 
        );
    }

    public function createSchool(array $data)
    {
        $peserta = $this->SekolahInterface->create($data);
        return Api::response(
            SchoolResource::make($peserta),
            'School created successfully',
            Response::HTTP_CREATED
        );
    }

    public function updateSchool(int $id, array $data)
    {
        $school = $this->SekolahInterface->update($id, $data);
        return Api::response(
            SchoolResource::make($school),
            'School updated successfully',
            Response::HTTP_OK
        );
    }

    public function deleteSchool(int $id)
    {
        $this->SekolahInterface->delete($id);
        return Api::response(
            null,
            'School deleted successfully',
            Response::HTTP_OK
        );
    }

    public function getSchoolById(int $id)
    {
        $school = $this->SekolahInterface->find($id);
        return Api::response(
            SchoolResource::make($school),
            'School fetched successfully',
            Response::HTTP_OK
        );
    }
}