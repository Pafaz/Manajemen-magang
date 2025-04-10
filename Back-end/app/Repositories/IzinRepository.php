<?php

namespace App\Repositories;

use App\Interfaces\IzinInterface;
use App\Models\Izin;
use Illuminate\Database\Eloquent\Collection;

class IzinRepository implements IzinInterface
{
    public function getAll(): Collection
    {
        return Izin::all();
    }

    public function find(int $id): ? Izin
    {
        return Izin::findOrFail($id)->first();
    }

    public function create(array $data): ? Izin
    {
        return Izin::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Izin::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Izin::findOrFail($id)->delete();
    }
}
