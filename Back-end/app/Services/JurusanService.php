<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Support\Facades\DB;
use App\Interfaces\JurusanInterface;
use App\Interfaces\SekolahInterface;
use App\Http\Resources\JurusanResource;
use Symfony\Component\HttpFoundation\Response;

class JurusanService
{
    private JurusanInterface $JurusanInterface;
    private SekolahInterface $SekolahInterface;

    public function __construct(JurusanInterface $JurusanInterface, SekolahInterface $SekolahInterface)
    {
        $this->JurusanInterface = $JurusanInterface;
        $this->SekolahInterface = $SekolahInterface;
    }

    public function getMajors()
    {
        $data = $this->JurusanInterface->getAll();
        return Api::response(
            JurusanResource::collection($data),
            'Jurusan Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function createMajor(array $data)
    {
        DB::beginTransaction();
        try {
            $jurusan = $this->JurusanInterface->firstOrCreate([
                'nama' => $data['nama'],
            ]);

            if ($jurusan->wasRecentlyCreated === false) {
                return Api::response(
                    null,
                    'Jurusan sudah ada dengan nama yang sama.',
                    Response::HTTP_CONFLICT // 409 Conflict
                );
            }

            $sekolah = $this->SekolahInterface->find($data['id_sekolah']);
            $sekolah->jurusan()->attach($jurusan->id); 

            DB::commit();

            return Api::response(
                JurusanResource::make($jurusan),
                'Jurusan created and linked to Sekolah successfully',
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            return Api::response(
                null,
                'Failed to create Jurusan: ' . $th->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
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
