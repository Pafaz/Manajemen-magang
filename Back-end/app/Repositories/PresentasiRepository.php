<?php

namespace App\Repositories;

use App\Interfaces\PresentasiInterface;
use App\Models\Presentasi;
use Illuminate\Database\Eloquent\Collection;

class PresentasiRepository implements PresentasiInterface
{
    public function getAll(): Collection
    {
        return Presentasi::all();
    }

    public function find(int $id): ? Presentasi
    {
        return Presentasi::findOrFail($id)->first();
    }

    public function create(array $data): ? Presentasi
    {
        return Presentasi::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Presentasi::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Presentasi::findOrFail($id)->delete();
    }
}
