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

    public function create(array $data): ? Perusahaan
    {
        return Perusahaan::create( [
            'id_user' => $data['id_user'],
            'deskripsi' => $data['deskripsi'],
            'alamat' => $data['alamat'],
            'website' => $data['website'],
            'instagram' => $data['instagram'],
            'is_premium' => $data['is_premium'], 
            'is_active' => $data['is_active'],
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
