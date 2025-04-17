<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Support\Facades\DB;
use App\Interfaces\JurusanInterface;
use App\Interfaces\SekolahInterface;
use App\Http\Resources\SchoolResource;
use Symfony\Component\HttpFoundation\Response;

class SekolahService 
{
    private SekolahInterface $SekolahInterface;
    private JurusanInterface $JurusanInterface;

    public function __construct(SekolahInterface $SekolahInterface, JurusanInterface $JurusanInterface)
    {
        $this->JurusanInterface = $JurusanInterface;
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
        DB::beginTransaction();
    try {
        $sekolah = $this->SekolahInterface->create([
            'nama' => $data['nama'],
            'alamat' => $data['alamat'],
            'telepon' => $data['telepon'],
        ]);

        $jurusanIds = [];

        foreach ($data['jurusan'] as $namaJurusan) {
            $jurusan = $this->JurusanInterface->firstOrCreate(['nama' => $namaJurusan]);
            $jurusanIds[] = $jurusan->id;
        }

        $sekolah->jurusan()->sync($jurusanIds);

        DB::commit();

        return Api::response(
            SchoolResource::make($sekolah->load('jurusan')),
            'Sekolah & jurusan berhasil disimpan',
            Response::HTTP_CREATED
        );
    } catch (\Throwable $th) {
        DB::rollBack();
        return Api::response(
            null,
            'Failed to create school: ' . $th->getMessage(),
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
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
        $school = $this->SekolahInterface->find($id);
        
        $school->jurusan()->detach();
        $school->delete(); 
        return Api::response(
            null,
            'School deleted successfully',
            Response::HTTP_OK
        );
    }

    public function getSchoolById(int $id)
    {
        $school = $this->SekolahInterface->find($id);
        $jurusan = $school->jurusan()->get();

        $response = [
            'sekolah' => SchoolResource::make($school),
            'jurusan' => $jurusan->map(function ($jurusan) {
                return [
                    'id' => $jurusan->id,
                    'nama' => $jurusan->nama,
                ];
            }),
        ];
        return Api::response(
            $response,
            'School fetched successfully',
            Response::HTTP_OK
        );
    }
}