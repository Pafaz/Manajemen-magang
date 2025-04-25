<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\CategoryResource;
use App\Interfaces\KategoriInterface;
use Symfony\Component\HttpFoundation\Response;

class KategoriService 
{
    private KategoriInterface $KategoriInterface;
    private FotoService $foto;

    public function __construct(KategoriInterface $KategoriInterface, FotoService $foto)
    {
        $this->KategoriInterface = $KategoriInterface;
        $this->foto = $foto;

    }

    public function getCategories($id = null)
    {
        $kategori = $this->KategoriInterface->find($id);
        if (!$kategori) {
            return Api::response(null, 'Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $data = $id
            ? CategoryResource::make($this->KategoriInterface->find($id))
            : CategoryResource::collection($this->KategoriInterface->getAll());

        $message = $id 
            ? 'Berhasil mengambil data kategori'
            : 'Berhasil mengambil semua data kategori';

        return Api::response($data, $message);
    }

    public function simpanKategori(array $data, bool $isUpdate = false, $id = null)
    {
        $user = auth('sanctum')->user();
        $perusahaanId = $user->perusahaan->id;

        // dd($perusahaanId);
        if (!$perusahaanId) {
            return Api::response(null, 'Perusahaan tidak ditemukan.', Response::HTTP_FORBIDDEN);
        }

        $category = $isUpdate
            ? $this->KategoriInterface->update(id: $id, data: [
                'id_perusahaan' => $perusahaanId,
                'nama' => $data['nama'],
            ])
            : $this->KategoriInterface->create([
                'id_perusahaan' => $perusahaanId,
                'nama' => $data['nama'],
            ]);
        
        // dd($category);
        if (!empty($data['card'])) {
            $isUpdate 
                ? $this->foto->updateFoto($data['card'], $category->id.$perusahaanId, 'card') 
                : $this->foto->createFoto($data['card'], $category->id.$perusahaanId, 'card');
        }
        $message = $isUpdate
            ? 'Berhasil memperbarui kategori'
            : 'Berhasil membuat kategori';

        $statusCode = $isUpdate
            ? Response::HTTP_OK
            : Response::HTTP_CREATED;

        return Api::response(
            CategoryResource::make($category),
            $message,
            $statusCode
        );

    }

    public function deleteCategory(int $id)
    {
        $this->KategoriInterface->delete($id);
        return Api::response(
            null,
            'Kategori berhasil dihapus',
            Response::HTTP_OK
        );
    }

}