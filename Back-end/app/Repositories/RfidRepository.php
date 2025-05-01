<?php

namespace App\Repositories;

use App\Interfaces\RfidInterface;
use App\Models\Rfid;
use Illuminate\Database\Eloquent\Collection;

class RfidRepository implements RfidInterface
{
    public function getAll($id): Collection
    {
        return Rfid::all();
    }

    public function find(int $id): ? Rfid
    {
        return Rfid::findOrFail($id)->first();
    }

    public function create(array $data): ? Rfid
    {
        return Rfid::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Rfid::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Rfid::findOrFail($id)->delete();
    }
}
