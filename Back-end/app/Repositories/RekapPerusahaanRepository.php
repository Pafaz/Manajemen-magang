<?php

namespace App\Repositories;

use App\Interfaces\RekapPerusahaanInterface;
use App\Models\RekapPerusahaan;
use Illuminate\Database\Eloquent\Collection;

class RekapPerusahaanRepository implements RekapPerusahaanInterface
{
    public function getAll(): Collection
    {
        return RekapPerusahaan::where('id_peserta', auth('sanctum')->user()->peserta->id)->get();
    }

    public function findOrCreateByPesertaBulanTahun( $peserta_id, $bulan, $tahun)
    {
        return RekapPerusahaan::firstOrCreate([
            'id_peserta' => $peserta_id,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    public function find(int $id): ? RekapPerusahaan
    {
        return RekapPerusahaan::findOrFail($id)->first();
    }

    public function create(array $data): ? RekapPerusahaan
    {
        return RekapPerusahaan::firstOrCreate( $data);
    }

    public function update(int $id, array $data): RekapPerusahaan
    {
        $category = RekapPerusahaan::findOrFail($id);
        $category->update($data);

        return $category;
    }

    public function delete(int $id): void
    {
        RekapPerusahaan::findOrFail($id)->delete();
    }
}
