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
        return Absensi::where('id_peserta', auth('sanctum')->user()->peserta->id)->get();
    }

    public function find(int $id): ? Absensi
    {
        return Absensi::findOrFail($id);
    }

    public function findByDate($idPeserta, $tanggal)
    {
        return Absensi::where('id_peserta', $idPeserta)
            ->whereDate('tanggal', $tanggal)
            ->first();
    }

    public function create(array $data): ? Absensi
    {
        return Absensi::create($data);
    }

    public function update(int $id, array $data): Model
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->update($data);
        return $absensi;
    }

    public function delete(int $id): void
    {
        Absensi::findOrFail($id)->delete();
    }

    public function countAbsensiByCabang(int $idCabang, int $bulan, int $tahun, string $status)
    {
        return Absensi::where('status', $status)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->whereHas('peserta.magang.lowongan', function ($query) use ($idCabang) {
                $query->where('id_cabang', $idCabang);
            })->count();
    }
}
