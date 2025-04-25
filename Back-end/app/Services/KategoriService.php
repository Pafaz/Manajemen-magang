<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\CategoryResource;
use App\Interfaces\KategoriInterface;
use Symfony\Component\HttpFoundation\Response;

class KategoriService 
{
    private KategoriInterface $KategoriInterface;

    public function __construct(KategoriInterface $KategoriInterface)
    {
        $this->KategoriInterface = $KategoriInterface;
    }

    public function getCategories()
    {
        
        $data = $this->KategoriInterface->getAll();
        return Api::response(
            CategoryResource::collection($data),
            'Berhasil mengambil data kategori', 
        );
    }

    public function simpanKategori(array $data, $isUpdate = false)
    {
        $user = auth('sanctum')->user();

        if ($isUpdate) {
            $category = $this->KategoriInterface->update(id: $data['id'], data: $data);
            return Api::response(
            CategoryResource::make($category),
            'Berhasil memperbarui kategori',
            Response::HTTP_OK
        );
        }

        $category = $this->KategoriInterface->create($data);
        return Api::response(
            CategoryResource::make($category),
            'Berhasil membuat kategori',
            Response::HTTP_CREATED
        );
    }

    public function updateCategory(int $id, array $data)
    {
        $category = $this->KategoriInterface->update($id, $data);
        return Api::response(
            CategoryResource::make($category),
            'Berhasil memperbarui kategori',
            Response::HTTP_OK
        );
    }

    public function deleteCategory(int $id)
    {
        $this->KategoriInterface->delete($id);
        return Api::response(
            null,
            'Category deleted successfully',
            Response::HTTP_OK
        );
    }

    public function getCategoryById(int $id)
    {
        $category = $this->KategoriInterface->find($id);
        return Api::response(
            CategoryResource::make($category),
            'Category fetched successfully',
            Response::HTTP_OK
        );
    }
}