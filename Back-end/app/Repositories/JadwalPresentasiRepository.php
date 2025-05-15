<?php

namespace App\Repositories;

use App\Interfaces\JadwalPresentasiInterface;
use App\Models\Jadwal_Presentasi;
use Illuminate\Database\Eloquent\Collection;

class JadwalPresentasiRepository implements JadwalPresentasiInterface
{
    public function getAll($id = null): Collection
    {
        return Jadwal_Presentasi::where('id_mentor', $id)->get();
    }

    public function find(int $id): ? Jadwal_Presentasi
    {
        return Jadwal_Presentasi::findOrFail($id)->first();
    }

    public function create(array $data): ? Jadwal_Presentasi
    {
        return Jadwal_Presentasi::create([
            "id_mentor"=> $data["id_mentor"],
            "tanggal"=> $data["tanggal"],
            "waktu_mulai"=> $data["waktu_mulai"],
            "waktu_selesai"=> $data["waktu_selesai"],
            "kuota"=> $data["kuota"],
            "tipe"=> $data["tipe"],
            "link_zoom"=> $data["link_zoom"] ?? null,
            "lokasi" => $data["lokasi"] ?? null,
            "status"=> $data["status"],
        ]);
    }

    public function update(int $id, array $data): mixed
    {
        return Jadwal_Presentasi::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Jadwal_Presentasi::findOrFail($id)->delete();
    }
}
