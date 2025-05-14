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

    public function find(int $id): ? Presentasi
    {
        return Presentasi::findOrFail($id)->first();
    }

    public function create(array $data): ? Presentasi
    {
        return Presentasi::create([
            "id_mentor"=> $data["id_mentor"],
            "judul"=> $data["judul"],
            'kuota' => $data['kuota'],
            'link_zoom'=> $data['link_zoom'],
            'tanggal'=> $data['tanggal'],
            'waktu_mulai'=> $data['waktu_mulai'],
            'waktu_selesai'=> $data['waktu_selesai'],
            'tipe'=> $data['tipe'],
        ]);
    }

    public function update(int $id, array $data): mixed
    {
        return Presentasi::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Presentasi::findOrFail($id)->delete();
    }
}
