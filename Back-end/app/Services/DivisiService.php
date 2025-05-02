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

    public function getDivisi($id = null)
    {
        $divisi = $id ? $this->DivisiInterface->find($id) : $this->DivisiInterface->getAll(auth('sanctum')->user()->id_cabang_aktif);
        if (!$divisi) {
            return Api::response(null, 'Divisi tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $data = $id
            ? DivisiResource::make($divisi)
            : DivisiResource::collection($divisi);

        $message = $id
            ? 'Berhasil mengambil data divisi'
            : 'Berhasil mengambil semua data divisi';

        return Api::response($data, $message);
    }

    public function simpanDivisi(array $data, bool $isUpdate = false, $id = null)
    {
        DB::beginTransaction();
        try {
            $divisiData = collect($data)->only('nama')->toArray();
            $divisiData['id_cabang'] = auth('sanctum')->user()->id_cabang_aktif;
            $divisi = $isUpdate
                ? $this->DivisiInterface->update($id, $divisiData)
                : $this->DivisiInterface->create($divisiData);

            $kategoriIds = [];
            if (!empty($data['kategori_proyek'])) {
                foreach ($data['kategori_proyek'] as $namaKategori) {
                    $kategori = $this->kategoriInterface->create(['nama' => $namaKategori]);
                    $kategoriIds[] = $kategori->id;
                }

                $divisi->kategori()->sync($kategoriIds);
            }

            if (!empty($data['foto_cover'])) {
                $isUpdate
                    ? $this->foto->updateFoto($data['foto_cover'], $divisi->id, 'foto_cover')
                    : $this->foto->createFoto($data['foto_cover'], $divisi->id, 'foto_cover');
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
        $divisi = $this->DivisiInterface->find($id);
        $divisi->kategori()->detach();
        $divisi->delete();
        return Api::response(
            null,
            'Divisi berhasil dihapus',
            Response::HTTP_OK
        );
    }
}
