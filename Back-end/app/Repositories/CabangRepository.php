<?php

namespace App\Repositories;

use App\Models\Cabang;

use App\Interfaces\CabangInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class CabangRepository implements CabangInterface
{
    public function getAll(): Collection
    {
        return Cabang::all();
    }

    public function getCabangByPerusahaanId($id)
    {
        return Cabang::where('id_perusahaan', $id)->get();
    }

    public function find(int $id, $perusahaanId): ?Cabang
    {
        return Cabang::where('id', $id)->where('id_perusahaan', $perusahaanId)->first();
    }

    public function create(array $data): ?Cabang
    {
        return Cabang::create($data);
    }

    public function update(int $id, array $data): Model
    {
        $cabang = Cabang::findOrFail($id);
        $cabang->update($data);
        return $cabang;
    }

    public function delete(int $id): void
    {
        Cabang::findOrFail($id)->delete();
    }
}
