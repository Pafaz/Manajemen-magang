<?php

namespace App\Repositories;

use App\Interfaces\JurnalInterface;
use App\Models\Jurnal;
use Illuminate\Database\Eloquent\Collection;

class JurnalRepository implements JurnalInterface
{
    public function getAll(): Collection
    {
        return Jurnal::with('peserta')->where('id_peserta', auth('sanctum')->user()->peserta->id)->get();
    }
    public function findByPesertaAndTanggal($idPeserta, $tanggal)
    {
        return Jurnal::where('id_peserta', $idPeserta)
            ->whereDate('tanggal', $tanggal)
            ->first();
    }
    public function find(int $id): ?Jurnal
    {
        return Jurnal::findOrFail($id)->first();
    }
    public function firstOrCreate(array $attributes): Jurnal
    {
        return Jurnal::firstOrCreate($attributes);
    }


    public function create(array $data): ?Jurnal
    {
        return Jurnal::create($data);
    }

    public function update(int $id, array $data): Jurnal
    {
        $jurnal = Jurnal::findOrFail($id);
        $jurnal->update($data);
        return $jurnal;
    }

    public function delete(int $id): void
    {
        Jurnal::findOrFail($id)->delete();
    }

    public function countByPerusahaan($id_perusahaan): int
    {
        return Jurnal::whereHas('peserta.magang.lowongan', function ($query) use ($id_perusahaan) {
            $query->where('id_perusahaan', $id_perusahaan);
        })->count();
    }
}
