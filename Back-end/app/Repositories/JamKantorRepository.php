<?php

namespace App\Repositories;

use App\Interfaces\JamKantorInterface;
use App\Models\Jam_Kantor;
use Illuminate\Database\Eloquent\Collection;

class JamKantorRepository implements JamKantorInterface
{
    public function getAll(): Collection
    {
        return Jam_Kantor::all();
    }

    public function find($hari): ? Jam_Kantor
    {
        return Jam_Kantor::where('hari', $hari)->first();
    }

    public function create(array $data): ? Jam_Kantor
    {
        return Jam_Kantor::create($data);
    }

    public function update($id, array $data): Jam_Kantor
    {
        $jamKantor = Jam_Kantor::findOrFail( $id );

        $jamKantor->update($data);

        return $jamKantor;
    }

    public function updateByHari($hari, $id_cabang, array $data): Jam_Kantor
    {
        $jamKantor = Jam_Kantor::where('hari', $hari)->where('id_cabang', $id_cabang)->first();

        if (!$jamKantor) {
            throw new \Exception("Jam kantor untuk hari {$hari} tidak ditemukan.");
        }

        $jamKantor->update($data);

        return $jamKantor;
    }

    public function findByHariAndCabang($hari, $id_cabang): ?Jam_Kantor
    {
        return Jam_Kantor::where('hari', $hari)->where('id_cabang', $id_cabang)->first();
    }



    public function delete(int $id): void
    {
        Jam_Kantor::findOrFail($id)->delete();
    }
}
