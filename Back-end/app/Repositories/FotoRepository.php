<?php

namespace App\Repositories;

use App\Interfaces\FotoInterface;
use App\Models\Foto;
use Illuminate\Database\Eloquent\Collection;

class FotoRepository implements FotoInterface
{
    public function getAll(): Collection
    {
        return Foto::all();
    }

    public function find( $id_referensi)
    {
        $p = Foto::where('id_referensi', '01965b92-8ab7-70d7-a81b-439675071244')->get();
        dd($p);
        // return 
    }

    public function create(array $data): ? Foto
    {
        return Foto::create($data);
    }

    public function update(int $id, array $data): Foto
    {
        $foto = Foto::findOrFail($id);
        $foto->update($data);
        return $foto;
    }

    public function delete(int $id): void
    {
        Foto::findOrFail($id)->delete();
    }

    public function getByTypeandReferenceId(string $type, $id_referensi): ?Foto
    {
        $foto = Foto::where('type', $type)->where('id_referensi', $id_referensi)->first();
        return $foto;
    }
}
