<?php

namespace App\Repositories;

use App\Interfaces\MagangInterface;
use App\Models\Magang;
use Illuminate\Database\Eloquent\Collection;

class MagangRepository implements MagangInterface
{
    public function getAll(): Collection
    {
        return Magang::all();
    }

    public function find(int $id): ? Magang
    {
        return Magang::findOrFail($id)->first();
    }

    public function create(array $data): ? Magang
    {
        return Magang::create($data);
    }

    public function update(int $id, array $data): mixed
    {
        return Magang::where('id', $id)->update($data);
    }

    public function delete(int $id): void
    {
        Magang::findOrFail($id)->delete();
    }
}
