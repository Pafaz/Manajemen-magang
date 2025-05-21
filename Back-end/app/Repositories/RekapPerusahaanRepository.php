<?php

namespace App\Repositories;

use App\Interfaces\RekapPerusahaanInterface;
use App\Models\RekapPerusahaan;
use Illuminate\Database\Eloquent\Collection;

class RekapPerusahaanRepository implements RekapPerusahaanInterface
{
    public function getAll(): Collection
    {
        return RekapKehadiran::where('id_peserta', auth('sanctum')->user()->peserta->id)->get();
    }

    public function findOrCreateByPesertaBulanTahun( $peserta_id, $bulan, $tahun)
    {
        return RekapKehadiran::firstOrCreate([
            'id_peserta' => $peserta_id,
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
