<?php

namespace App\Repositories;

use App\Interfaces\KategoriInterface;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Collection;

class KategoriRepository implements KategoriInterface
{
    public function getAll($id): Collection
    {
        return Kategori::all();
    }

    public function find(int $id): ? Kategori
    {
        return Kategori::findOrFail($id)->first();
    }

    public function create(array $data): ? Kategori
    {
        return Kategori::firstOrCreate( $data);
    }

    public function update(int $id, array $data): Kategori
    {
        $category = Kategori::findOrFail($id);
        $category->update($data);
        
        return $category;
    }

    public function delete(int $id): void
    {
        Kategori::findOrFail($id)->delete();
    }
}
