<?php

namespace App\Repositories;

use App\Interfaces\CabangInterface;
use App\Interfaces\PiketInterface;
use App\Models\Cabang;
use App\Models\Piket;
use Illuminate\Database\Eloquent\Collection;

class PiketRepository implements PiketInterface
{
    public function getAll($id = null): Collection
    {
        return Piket::where("id_cabang", $id)->with('peserta')->get();
    }

    public function find(int $id): ? Piket
    {
        return Piket::findOrFail($id)->first();
    }

    public function create(array $data): ? Piket
    {
        $piket = Piket::create([
            'id_cabang' => $data['id_cabang'],
            'shift' => $data['shift'],
            'hari'=> $data['hari'],
        ]);

        foreach ($data['peserta'] as $peserta) {
            $piket->peserta()->attach($peserta);
        }

        return $piket;
    }

    public function update($id, array $data): Piket
    {
        $piket = Piket::findOrFail($id);
        
        $piket->update([
            'id_cabang' => $data['id_cabang'],
            'shift' => $data['shift'],
            'hari' => $data['hari'],
        ]);
        
        // Sync peserta if provided in the data
        if (isset($data['peserta'])) {
            $piket->peserta()->sync($data['peserta']);
        }
        
        return $piket->load('peserta');
    }

    public function delete(int $id): void
    {
        Piket::findOrFail($id)->delete();
    }
}
