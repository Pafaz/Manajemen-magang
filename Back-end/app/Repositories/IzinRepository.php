<?php

namespace App\Repositories;

use App\Interfaces\IzinInterface;
use App\Models\Izin;
use Illuminate\Database\Eloquent\Collection;

class IzinRepository implements IzinInterface
{
    public function getAll(): Collection
    {
        return Izin::where('id_cabang', auth('sanctum')->user()->id_cabang_aktif)->get();
    }

    public function find(int $id): ? Izin
    {
        return Izin::findOrFail($id);
    }

    public function create(array $data): ? Izin
    {
        return Izin::create($data);
    }

    public function update(int $id, array $data): Izin
    {
        $izin = Izin::findOrFail($id);
        $izin->update($data);
        return $izin;
    }

    public function delete(int $id): void
    {
        Izin::findOrFail($id)->delete();
    }
}
