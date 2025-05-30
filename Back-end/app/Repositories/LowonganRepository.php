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

    public function getByPerusahaan($id)
    {
        $lowongan = Lowongan::where("id_perusahaan", $id)->get();
        return $lowongan;
    }

    public function find(int $id): ?Lowongan
    {
        return Lowongan::findOrFail($id);
    }

    public function create(array $data): ?Lowongan
    {
        return Lowongan::create($data);
    }

    public function update(int $id, array $data): Lowongan
    {
        $lowongan = Lowongan::findOrFail($id);
        $lowongan->update($data);
        return $lowongan;
    }


    public function delete(int $id): void
    {
        Lowongan::findOrFail($id)->delete();
    }
}