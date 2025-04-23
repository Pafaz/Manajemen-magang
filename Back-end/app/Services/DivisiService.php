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
            $divisi = $this->DivisiInterface->create($data);
            // dd(get_class($divisi), $divisi);


            if ($divisi->wasRecentlyCreated === false) {
                DB::rollBack();

                return Api::response(
                    null,
                    'Divisi sudah ada dengan nama yang sama.',
                    Response::HTTP_CONFLICT
                );
            }

            DB::commit();

            return Api::response(
                DivisiResource::make($divisi),
                'Divisi created successfully',
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            return Api::response(
                null,
                'Failed to create Divisi: ' . $th->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }


    public function updateDivisi(int $id, array $data)
    {
        $jurusan = $this->DivisiInterface->update($id, $data);
        return Api::response(
            DivisiResource::make($jurusan),
            'Divisi updated successfully',
            Response::HTTP_OK
        );
    }

    public function deleteDivisi(int $id)
    {
        $this->DivisiInterface->delete($id);
        return Api::response(
            null,
            'Divisi deleted successfully',
            Response::HTTP_OK
        );
    }

    public function getDivisiById(int $id)
    {
        $divisi = $this->DivisiInterface->find($id);
        return Api::response(
            DivisiResource::make($divisi),
            'Divisi fetched successfully',
            Response::HTTP_OK
        );
    }
}
