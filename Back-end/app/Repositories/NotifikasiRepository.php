<?php

namespace App\Repositories;

use App\Interfaces\NotifikasiInterface;
use App\Models\Notifikasi;
use Illuminate\Database\Eloquent\Collection;

class NotifikasiRepository implements NotifikasiInterface
{
    public function getAll($id): Collection
    {
        return Notifikasi::all();
    }

    public function find(int $id): ? Notifikasi
    {
        return Notifikasi::findOrFail($id)->first();
    }

    public function create(array $data): ? Notifikasi
    {
        return Notifikasi::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Notifikasi::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Notifikasi::findOrFail($id)->delete();
    }
}
