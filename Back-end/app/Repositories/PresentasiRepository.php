<?php

namespace App\Repositories;

use App\Interfaces\PresentasiInterface;
use App\Models\Presentasi;
use Illuminate\Database\Eloquent\Collection;

class PresentasiRepository implements PresentasiInterface
{
    public function getAll(): Collection
    {
        return Presentasi::all();
    }

    public function getPresentasiPeserta(string $id_peserta)
    {
        return Presentasi::where('id_peserta', $id_peserta)->get();
    }

    public function find(int $id): ? Presentasi
    {
        return Presentasi::findOrFail($id)->first();
    }

    public function create(array $data): ? Presentasi
    {
        return Presentasi::create([
            "id_peserta"=> $data["id_peserta"],
            "id_jadwal_presentasi"=> $data["id_jadwal_presentasi"],
            "projek"=> $data["projek"]
        ]);
    }

    public function update(int $id, array $data): Presentasi
    {
        $presentasi = Presentasi::findOrFail($id);
        $presentasi->update($data);
        return $presentasi;
    }

    public function delete(int $id): void
    {
        Presentasi::findOrFail($id)->delete();
    }
}
