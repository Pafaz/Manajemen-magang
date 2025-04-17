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

    public function find(int $id): ? Jam_Kantor
    {
        return Jam_Kantor::findOrFail($id)->first();
    }

    public function create(array $data): ? Jam_Kantor
    {
        return Jam_Kantor::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Jam_Kantor::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Jam_Kantor::findOrFail($id)->delete();
    }
}
