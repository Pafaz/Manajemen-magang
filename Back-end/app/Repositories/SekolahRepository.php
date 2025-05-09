<?php

namespace App\Repositories;

use App\Interfaces\SekolahInterface;
use App\Models\Sekolah;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SekolahRepository implements SekolahInterface
{
    public function getAll($id_perusahaan): Collection
    {
        return Sekolah::where('id_perusahaan', $id_perusahaan)->get();
    }

    public function find(int $id): ? Sekolah
    {
        return Sekolah::findOrFail($id)->first();
    }

    public function create(array $data): ? Sekolah
    {
        return Sekolah::create([
            'nama' => $data['nama'],
            'alamat' => $data['alamat'],
            'telepon' => $data['telepon'],
            'jenis_institusi' => $data['jenis_institusi'],
            'id_perusahaan' => $data['id_perusahaan'],
        ]);
    }

    public function update(int $id, array $data): Model
    {
        $school = Sekolah::findOrFail($id);
        $school->update($data);
        return $school;
    }

    public function delete(int $id): void
    {
        Sekolah::findOrFail($id)->delete();
    }
}
