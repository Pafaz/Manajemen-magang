<?php

namespace App\Repositories;

use App\Interfaces\CabangInterface;
use App\Interfaces\ProgressInterface;
use App\Models\Cabang;
use App\Models\Progress;
use Illuminate\Database\Eloquent\Collection;

class ProgressRepository implements ProgressInterface
{
    public function getAll(): Collection
    {
        return Progress::all();
    }

    public function find(int $id): ? Progress
    {
        return Progress::findOrFail($id)->first();
    }

    public function create(array $data): ? Progress
    {
        return Progress::create([ $data]);
    }

    public function update(int $id, array $data): mixed
    {
        return Progress::where('id', $id)->update([$data]);
    }

    public function delete(int $id): void
    {
        Progress::findOrFail($id)->delete();
    }
}
