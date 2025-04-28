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
    private FotoService $foto;

    public function __construct(SekolahInterface $SekolahInterface, JurusanInterface $JurusanInterface, FotoService $foto)
    {
        $this->JurusanInterface = $JurusanInterface;
        $this->SekolahInterface = $SekolahInterface;
        $this->foto = $foto;
    }

    public function getSchools($id = null)
    {
        $school = $id ? $this->SekolahInterface->find($id) : $this->SekolahInterface->getAll();

        if (!$school) {
            return Api::response(null, 'Sekolah tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $data = $id 
            ? SchoolResource::make($school) 
            : SchoolResource::collection($school);

        $message = $id 
            ? 'Berhasil mengambil data sekolah' 
            : 'Berhasil mengambil semua data sekolah';

        return Api::response($data, $message);
    }


    public function simpanMitra(array $data, bool $isUpdate = false, $id = null)
    {
        DB::beginTransaction();
        try {
            $dataSekolah = collect($data)->only(['nama', 'alamat', 'telepon', 'jenis_institusi', 'website'])->toArray();

            $sekolah = $isUpdate
                ? $this->SekolahInterface->update($id, $dataSekolah)
                : $this->SekolahInterface->create($dataSekolah);

            $jurusanIds = [];
            if (!empty($data['jurusan'])) {
                foreach ($data['jurusan'] as $namaJurusan) {
                    $jurusan = $this->JurusanInterface->firstOrCreate(['nama' => $namaJurusan]);
                    $jurusanIds[] = $jurusan->id;
                }
                $sekolah->jurusan()->sync($jurusanIds);
            }

            if (!empty($data['foto_header'])) {
                $isUpdate 
                    ? $this->foto->updateFoto($data['foto_header'], $sekolah->id, 'foto_header_sekolah') 
                    : $this->foto->createFoto($data['foto_header'], $sekolah->id, 'foto_header_sekolah');
            }

            DB::commit();

            $message = $isUpdate
                ? 'Sekolah & jurusan berhasil diperbarui'
                : 'Sekolah & jurusan berhasil disimpan';

            $statusCode = $isUpdate
                ? Response::HTTP_OK
                : Response::HTTP_CREATED;

            return Api::response(
                SchoolResource::make($sekolah->load('jurusan', 'foto')),
                $message,
                $statusCode
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            return Api::response(
                null,
                'Gagal menyimpan sekolah: ' . $th->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deleteSchool(int $id)
    {
        $school = $this->SekolahInterface->find($id);
        
        $school->jurusan()->detach();
        $school->delete(); 
        return Api::response(
            null,
            'Berhasil menghapus data sekolah',
            Response::HTTP_OK
        );
    }
}