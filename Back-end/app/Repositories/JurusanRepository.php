<?php

namespace App\Repositories;

use App\Interfaces\JurusanInterface;
use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Collection;

class JurusanRepository implements JurusanInterface
{
    public function getAll(): Collection
    {
        return Jurusan::all();
    }

    public function find(int $id): ? Jurusan
    {
        return Jurusan::findOrFail($id)->first();
    }

    public function create(array $data): ? Jurusan
    {
        return Jurusan::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Jurusan::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Jurusan::findOrFail($id)->delete();
    }
}
