<?php

namespace App\Repositories;

use App\Interfaces\CabangInterface;
use App\Interfaces\PiketInterface;
use App\Models\Cabang;
use App\Models\Piket;
use Illuminate\Database\Eloquent\Collection;

class PiketRepository implements PiketInterface
{
    public function getAll($id): Collection
    {
        return Piket::all();
    }

    public function find(int $id): ? Piket
    {
        return Piket::findOrFail($id)->first();
    }

    public function create(array $data): ? Piket
    {
        return Piket::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Piket::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Piket::findOrFail($id)->delete();
    }
}
