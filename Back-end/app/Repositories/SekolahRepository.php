<?php

namespace App\Repositories;

use App\Interfaces\SekolahInterface;
use App\Models\Sekolah;
use Illuminate\Database\Eloquent\Collection;

class SekolahRepository implements SekolahInterface
{
    public function getAll(): Collection
    {
        return Sekolah::all();
    }

    public function find(int $id): ? Sekolah
    {
        return Sekolah::findOrFail($id)->first();
    }

    public function create(array $data): ? Sekolah
    {
        return Sekolah::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Sekolah::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Sekolah::findOrFail($id)->delete();
    }
}
