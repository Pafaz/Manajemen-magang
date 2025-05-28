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
        $rekap = RekapCabang::where('id_cabang', $id)->first();
        return $rekap;
    }

    public function create(array $data): ? RekapCabang
    {
        return RekapCabang::firstOrCreate( $data);
    }

    public function update($id_cabang, array $data): RekapCabang
    {
        // $data['peserta_per_bulan_tahun'] = json_encode($data['peserta_per_bulan_tahun']);

        $rekap = RekapCabang::updateOrCreate(['id_cabang' => $id_cabang], $data);

        return $rekap;
    }
}
