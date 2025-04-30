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
        DB::beginTransaction();
    
        try {
            $cabang = auth('sanctum')->user()->perusahaan->cabang;
            dd($cabang->id);
            $divisiData = collect($data)->only(['nama', 'id_cabang'])->toArray();
    
            $divisi = $isUpdate
                ? $this->DivisiInterface->update($id, $divisiData)
                : $this->DivisiInterface->create($divisiData);
    
            $kategoriIds = [];
            if (!empty($data['kategori'])) {
                foreach ($data['kategori'] as $namaKategori) {
                    $kategori = $this->kategoriInterface->create(['nama' => $namaKategori]);
                    $kategoriIds[] = $kategori->id;
                }
    
                $divisi->kategori()->sync($kategoriIds);
            }
    
            if (!empty($data['header_divisi'])) {
                $isUpdate
                    ? $this->foto->updateFoto($data['header_divisi'], $divisi->id, 'header_divisi')
                    : $this->foto->createFoto($data['header_divisi'], $divisi->id, 'header_divisi');
            }
    
            DB::commit();
    
            $message = $isUpdate
                ? 'Divisi & kategori berhasil diperbarui'
                : 'Divisi & kategori berhasil disimpan';
    
            $statusCode = $isUpdate
                ? Response::HTTP_OK
                : Response::HTTP_CREATED;
    
            return Api::response(
                DivisiResource::make($divisi->load('kategori', 'foto')),
                $message,
                $statusCode
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            return Api::response(
                null,
                'Gagal menyimpan divisi: ' . $th->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
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
