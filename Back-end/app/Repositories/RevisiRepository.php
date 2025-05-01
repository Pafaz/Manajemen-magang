<?php

namespace App\Repositories;

use App\Interfaces\RevisiInterface;
use App\Models\Revisi;
use Illuminate\Database\Eloquent\Collection;

class RevisiRepository implements RevisiInterface
{
    public function getAll($id): Collection
    {
        return Revisi::all();
    }

    public function find(int $id): ? Revisi
    {
        return Revisi::findOrFail($id)->first();
    }

    public function create(array $data): ? Revisi
    {
        return Revisi::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Revisi::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Revisi::findOrFail($id)->delete();
    }
}
