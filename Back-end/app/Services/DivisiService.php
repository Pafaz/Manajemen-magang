<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\DivisiResource;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\JurusanResource;
use App\Interfaces\DivisiInterface;
use Symfony\Component\HttpFoundation\Response;

class DivisiService
{
    private DivisiInterface $DivisiInterface;

    public function __construct(DivisiInterface $DivisiInterface)
    {
        $this->DivisiInterface = $DivisiInterface; 
    }

    public function getAllDivisi()
    {
        $data = $this->DivisiInterface->getAll();
        return Api::response(
            DivisiResource::collection($data), 
            'Divisi Fetched Successfully',
        );
    }

    public function createDivisi(array $data)
    {
        DB::beginTransaction();
        try {
            $divisi = $this->DivisiInterface->create([
                'nama' => $data['nama'],
            ]);

            if ($divisi->wasRecentlyCreated === false) {
                return Api::response(
                    null,
                    'Jurusan sudah ada dengan nama yang sama.',
                    Response::HTTP_CONFLICT 
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
