<?php

namespace App\Repositories;

use App\Interfaces\CabangInterface;
use App\Interfaces\ProgressInterface;
use App\Models\Cabang;
use App\Models\Progress;
use Illuminate\Database\Eloquent\Collection;

class ProgressRepository implements ProgressInterface
{

    public function find(int $id): ? Progress
    {
        return Progress::findOrFail($id);
    }

    public function findByRevisi(int $id)
    {
        return Progress::where('id_revisi', $id)->get();
    }

    public function create(array $data): ? Progress
    {
        return Progress::create( $data);
    }

    public function update(int $id, array $data): Progress
    {
        $progress = Progress::findOrFail($id);
        $progress->update($data);
        return $progress;
    }

    public function delete(int $id): void
    {
        Progress::destroy($id);
    }
}
