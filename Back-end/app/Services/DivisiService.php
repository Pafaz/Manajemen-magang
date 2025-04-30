<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\DivisiResource;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\JurusanResource;
use App\Interfaces\DivisiInterface;
use App\Interfaces\KategoriInterface;
use Symfony\Component\HttpFoundation\Response;

class DivisiService
{
    private DivisiInterface $DivisiInterface;
    private FotoService $foto;
    private KategoriInterface $kategoriInterface;
    public function __construct(DivisiInterface $DivisiInterface, FotoService $foto, KategoriInterface $kategoriInterface)
    {
        $this->DivisiInterface = $DivisiInterface;
        $this->foto = $foto;
        $this->kategoriInterface = $kategoriInterface;
    }

    public function getAllDivisi()
    {
        $data = $this->DivisiInterface->getAll();
        return Api::response(
            DivisiResource::collection($data), 
            'Divisi Fetched Successfully',
        );
    }

    public function simpanDivisi(array $data, bool $isUpdate = false, $id = null)
    {
        $perusahaanId = auth('sanctum')->user()->perusahaan->id;
        if (!$perusahaanId) {
            return Api::response(null, 'Perusahaan tidak ditemukan.', Response::HTTP_FORBIDDEN);
        }

        $divisi = $isUpdate
            ? $this->DivisiInterface->update(id: $id, data: [
                'id_perusahaan' => $perusahaanId,
                'nama' => $data['nama'],
            ])
            : $this->DivisiInterface->create([
                'id_perusahaan' => $perusahaanId,
                'nama' => $data['nama'],
            ]);

            $category = $isUpdate
            ? $this->kategoriInterface->update(id: $id, data: [
                'id_perusahaan' => $perusahaanId,
                'nama' => $data['nama'],
            ])
            : $this->kategoriInterface->create([
                'id_perusahaan' => $perusahaanId,
                'nama' => $data['nama'],
            ]);

        if (!empty($data['header_divisi'])) {
            $isUpdate 
                ? $this->foto->updateFoto($data['header_divisi'], $divisi->id.$divisi->nama.$perusahaanId, 'header_divisi') 
                : $this->foto->createFoto($data['header_divisi'], $divisi->id.$divisi->nama.$perusahaanId, 'header_divisi');
        }

        $message = $isUpdate
            ? 'Berhasil memperbarui divisi'
            : 'Berhasil membuat divisi';

        $statusCode = $isUpdate
            ? Response::HTTP_OK
            : Response::HTTP_CREATED;

        return Api::response(
            DivisiResource::make($divisi),
            $message,
            $statusCode,
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
