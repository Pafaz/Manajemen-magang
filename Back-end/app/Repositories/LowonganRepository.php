<?php

namespace App\Repositories;

use App\Interfaces\LowonganInterface;
use App\Models\Lowongan;
use Illuminate\Database\Eloquent\Collection;

class LowonganRepository implements LowonganInterface
{
    public function getAll(): Collection
    {
        return Lowongan::all();
    }

    public function find(int $id): ? Lowongan
    {
        return Lowongan::findOrFail($id)->first();
    }

    public function create(array $data): ? Lowongan
    {
        return Lowongan::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Lowongan::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Lowongan::findOrFail($id)->delete();
    }
}
