<?php

namespace App\Repositories;

use App\Interfaces\AbsensiInterface;
use App\Models\Absensi;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AbsensiRepository implements AbsensiInterface
{
    public function getAll(): Collection
    {
        return Absensi::all();
    }

    public function find(int $id): ? Absensi
    {
        return Absensi::findOrFail($id)->first();
    }

    public function findByDate($idPeserta, $tanggal)
{
    return Absensi::where('id_peserta', $idPeserta)
        ->whereDate('tanggal', $tanggal)
        ->first();
}

    public function create(array $data): ? Absensi
    {
        return Absensi::create([$data]);
    }

    public function update(int $id, array $data): Model
    {
        $absensi = Absensi::where('id', $id);
        $absensi->update([$data]);
        return $absensi;
    }

    public function delete(int $id): void
    {
        Absensi::findOrFail($id)->delete();
    }
}
