<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Support\Facades\DB;
use App\Interfaces\DivisiInterface;
use App\Interfaces\KategoriInterface;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\DivisiResource;
use App\Http\Resources\JurusanResource;
use App\Http\Resources\DivisiCabangResource;
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
        $id_cabang = auth('sanctum')->user()->id_cabang_aktif;

        $cacheKey = $id ? "divisi_". $id : "divisi_cabang_". $id_cabang;
        
        $divisi = Cache::remember($cacheKey, 3600, function () use ( $id, $id_cabang ) {
            $divisi = $id ? $this->DivisiInterface->find($id) : $this->DivisiInterface->getAll($id_cabang);
            return $divisi;
        });

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
            $divisiData = collect($data)->only(['nama'])->toArray();
            $divisiData['id_cabang'] = auth('sanctum')->user()->id_cabang_aktif;
            $divisi = $isUpdate ? $this->DivisiInterface->update($id, $divisiData) : $this->DivisiInterface->create($divisiData);

            if ($isUpdate == true) {
                Cache::forget('divisi_'. $id);
            } else {
                Cache::forget('divisi_cabang'. $divisiData['id_cabang']);
            }

            $kategoriIds = [];
            foreach ($data['kategori_proyek'] as $kategoriItem) {
                $kategori = $this->kategoriInterface->create([
                    'nama' => $kategoriItem['nama'],
                ]);
                $kategoriIds[$kategori->id] = ['urutan' => $kategoriItem['urutan']];
            }
            $divisi->kategori()->sync($kategoriIds);


            if (!empty($data['foto_cover'])) {
                $this->foto->updateFoto($data['foto_cover'], $divisi->id, 'foto_cover', 'divisi');
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
        Cache::forget('divisi_cabang_'.$divisi->id_cabang);
        return Api::response(
            null,
            'Divisi berhasil dihapus'
        );
    }

    public function getByCabang(int $id)
    {
        $divisi = Cache::remember('divisi_cabang_'. $id, 3600, function () use ($id) {
            return $this->DivisiInterface->getByCabang($id);
        });

        return Api::response(
            DivisiCabangResource::collection($divisi),
            'Divisi Berhasil ditampilkan'
        );
    }
}
