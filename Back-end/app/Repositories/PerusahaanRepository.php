<?php

namespace App\Repositories;

use App\Interfaces\PerusahaanInterface;
use App\Models\Perusahaan;
use Illuminate\Database\Eloquent\Collection;

class PerusahaanRepository implements PerusahaanInterface
{
    public function getAll(): Collection
    {
        return Perusahaan::all();
    }

    public function find( $id): ? Perusahaan
    {
        return Perusahaan::findOrFail($id)->first();
    }

    public function findByUser($id): ? Perusahaan
    {
        return Perusahaan::where('id_user' , $id)->first();
    }

    public function create(array $data): ? Perusahaan
    {
        return Perusahaan::create( [
            'id_user' => auth('sanctum')->user()->id,
            'deskripsi' => $data['deskripsi'],
            'provinsi' => $data['provinsi'],
            'kota' => $data['kota'],
            'alamat' => $data['alamat'],
            'bidang_usaha' => $data['bidang_usaha'],
            'kode_pos' => $data['kode_pos'],
            'website' => $data['website'],
            'instagram' => $data['instagram'],
        ]);
    }

    public function update( $id, array $data): Perusahaan
    {
        return tap(Perusahaan::findOrFail($id))->update($data);
    }

    public function delete( $id): void
    {
        Perusahaan::findOrFail($id)->delete();
    }
}
