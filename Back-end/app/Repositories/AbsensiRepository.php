<?php

namespace App\Repositories;

use App\Interfaces\AbsensiInterface;
use App\Models\Absensi;
use Illuminate\Database\Eloquent\Collection;

class AbsensiRepository implements AbsensiInterface
{
    public function getAll(): Collection
    {
        return Absensi::all();
    }

    public function find(int $id): ? Absensi
    {
        return Absensi::findOrFail($id)->first();
    }

    public function create(array $data): ? Absensi
    {
        return Absensi::create([$data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Absensi::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Absensi::findOrFail($id)->delete();
    }
}
