<?php

namespace App\Repositories;

use App\Interfaces\DivisiInterface;
use App\Models\Divisi;
use Illuminate\Database\Eloquent\Collection;

class DivisiRepository implements DivisiInterface
{
    public function getAll(): Collection
    {
        return Divisi::all();
    }

    public function find(int $id): ? Divisi
    {
        return Divisi::findOrFail($id);
    }

    public function create(array $data): ? Divisi
    {
        return Divisi::firstOrCreate($data);
    }

    public function update(int $id, array $data): Divisi
    {
        $divisi = Divisi::findOrFail($id);
        $divisi->update($data);
        return $divisi;
    }

    public function delete(int $id): void
    {
        Divisi::findOrFail($id)->delete();
    }
}
