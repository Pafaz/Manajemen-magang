<?php

namespace App\Repositories;

use App\Interfaces\MagangInterface;
use App\Models\Magang;
use Illuminate\Database\Eloquent\Collection;

class MagangRepository implements MagangInterface
{
    public function getAll($id): Collection
    {
        return Magang::with('peserta', 'lowongan', 'foto')
            ->where('status', 'menunggu')
            ->whereHas('lowongan', function ($query) use ($id) {
                $query->where('id_cabang', $id);
            })->get();
    }

    public function find(int $id): ? Magang
    {
        return Magang::findOrFail($id);
    }

    public function alreadyApply($idPeserta, $idLowongan): ? Magang
    {
        return Magang::where('id_peserta', $idPeserta)->where('id_lowongan', $idLowongan)->first();
    }

    public function create(array $data): ? Magang
    {
        return Magang::create($data);
    }

    public function update(int $id, array $data): mixed
    {
        return Magang::where('id', $id)->update($data);
    }

    public function delete(int $id): void
    {
        Magang::findOrFail($id)->delete();
    }

    public function countPendaftar($lowonganId): int
    {
        return Magang::where('id_lowongan', $lowonganId)->count();
    }
}
