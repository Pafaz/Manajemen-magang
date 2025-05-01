<?php

namespace App\Repositories;

use App\Interfaces\ProyekInterface;
use App\Models\Proyek;
use Illuminate\Database\Eloquent\Collection;

class ProyekRepository implements ProyekInterface
{
    public function getAll($id): Collection
    {
        return Proyek::all();
    }

    public function find(int $id): ? Proyek
    {
        return Proyek::findOrFail($id)->first();
    }

    public function create(array $data): ? Proyek
    {
        return Proyek::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Proyek::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Proyek::findOrFail($id)->delete();
    }
}
