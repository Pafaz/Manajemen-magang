<?php

namespace App\Repositories;

use App\Interfaces\JadwalPresentasiInterface;
use App\Models\Jadwal_Presentasi;
use Illuminate\Database\Eloquent\Collection;

class JadwalPresentasiRepository implements JadwalPresentasiInterface
{
    public function getAll($id): Collection
    {
        return Jadwal_Presentasi::all();
    }

    public function find(int $id): ? Jadwal_Presentasi
    {
        return Jadwal_Presentasi::findOrFail($id)->first();
    }

    public function create(array $data): ? Jadwal_Presentasi
    {
        return Jadwal_Presentasi::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Jadwal_Presentasi::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Jadwal_Presentasi::findOrFail($id)->delete();
    }
}
