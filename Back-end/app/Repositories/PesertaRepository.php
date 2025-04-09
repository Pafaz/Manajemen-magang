<?php

namespace App\Repositories;

use App\Interfaces\PesertaInterface;
use App\Models\Peserta;
use Illuminate\Database\Eloquent\Collection;

class PesertaRepository implements PesertaInterface
{
    public function getAll(): Collection
    {
        return Peserta::all();
    }

    public function find(int $id): ? Peserta
    {
        return Peserta::findOrFail($id)->first();
    }

    public function create(array $data): ? Peserta
    {
        return Peserta::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Peserta::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Peserta::findOrFail($id)->delete();
    }
}
