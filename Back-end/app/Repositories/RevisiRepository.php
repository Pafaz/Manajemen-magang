<?php

namespace App\Repositories;

use App\Interfaces\RevisiInterface;
use App\Models\Revisi;
use Illuminate\Database\Eloquent\Collection;

class RevisiRepository implements RevisiInterface
{
    public function getAll(): Collection
    {
        return Revisi::all();
    }

    public function find(int $id): ?Revisi
    {
        return Revisi::with('progress')->findOrFail($id);
    }
    public function create(array $data): ? Revisi
    {
        return Revisi::create($data);
    }

    public function update(int $id, array $data): Revisi
    {
        $revisi = Revisi::findOrFail($id);
        $revisi->update($data);
        return $revisi;
    }

    public function delete(int $id): void
    {
        Revisi::findOrFail($id)->delete();
    }
}
