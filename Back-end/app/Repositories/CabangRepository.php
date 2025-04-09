<?php

namespace App\Repositories;

use App\Interfaces\CabangInterface;

use App\Models\Cabang;
use Illuminate\Database\Eloquent\Collection;

class CabangRepository implements CabangInterface
{
    public function getAll(): Collection
    {
        return Cabang::all();
    }

    public function find(int $id): ? Cabang
    {
        return Cabang::findOrFail($id)->first();
    }

    public function create(array $data): ? Cabang
    {
        return Cabang::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Cabang::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Cabang::findOrFail($id)->delete();
    }
}
