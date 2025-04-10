<?php

namespace App\Repositories;

use App\Interfaces\PerusahaanInterface;
use App\Models\Perusahaan;
use Illuminate\Database\Eloquent\Collection;

class PerusahaanRepository implements PerusahaanInterface
{
    public function getAll(): Collection
    {
        return Perusahaan::all();
    }

    public function find(int $id): ? Perusahaan
    {
        return Perusahaan::findOrFail($id)->first();
    }

    public function create(array $data): ? Perusahaan
    {
        return Perusahaan::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Perusahaan::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Perusahaan::findOrFail($id)->delete();
    }
}
