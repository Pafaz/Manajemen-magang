<?php

namespace App\Repositories;

use App\Interfaces\RekapKehadiranInterface;
use App\Models\RekapKehadiran;
use Illuminate\Database\Eloquent\Collection;

class RekapKehadiranRepository implements RekapKehadiranInterface
{
    public function getAll(): Collection
    {
        return RekapKehadiran::all();
    }

    public function findOrCreateByPesertaBulanTahun( $peserta_id, $bulan, $tahun)
    {
        return RekapKehadiran::firstOrCreate([
            'peserta_id' => $peserta_id,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    public function find(int $id): ? RekapKehadiran
    {
        return RekapKehadiran::findOrFail($id)->first();
    }

    public function create(array $data): ? RekapKehadiran
    {
        return RekapKehadiran::firstOrCreate( $data);
    }

    public function update(int $id, array $data): RekapKehadiran
    {
        $category = RekapKehadiran::findOrFail($id);
        $category->update($data);

        return $category;
    }

    public function delete(int $id): void
    {
        RekapKehadiran::findOrFail($id)->delete();
    }
}
