<?php

namespace App\Repositories;

use App\Interfaces\RekapCabangInterface;
use App\Models\RekapCabang;
use Illuminate\Database\Eloquent\Collection;

class RekapCabangRepository implements RekapCabangInterface
{
    public function getAll(): Collection
    {
        return RekapCabang::where('id_cabang', auth()->user()->id_cabang_aktif)->get();
    }

    public function find(int $id): ? RekapCabang
    {
        $rekap = RekapCabang::findOrFail($id)->first();
        return $rekap;
    }

    public function create(array $data): ? RekapCabang
    {
        return RekapCabang::firstOrCreate( $data);
    }

    public function update(int $id_cabang, array $data): RekapCabang
    {
        $rekap = RekapCabang::updateOrCreate(['id_cabang' => $id_cabang], $data);

        return $rekap;
    }
}
