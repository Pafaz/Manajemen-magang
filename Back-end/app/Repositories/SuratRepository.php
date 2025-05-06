<?php

namespace App\Repositories;

use App\Interfaces\SuratInterface;
use App\Models\Surat;
use Illuminate\Database\Eloquent\Collection;

class SuratRepository implements SuratInterface
{
    public function getAll(): Collection
    {
        return Surat::all();
    }

    public function find(int $id): ? Surat
    {
        return Surat::findOrFail($id)->first();
    }

    public function create(array $data): ? Surat
    {
        return Surat::create( $data);
    }

    public function update(int $id, array $data): mixed
    {
        $surat = Surat::findOrFail($id);
        $surat->update($data);
        return $surat;
    }

    public function delete(int $id): void
    {
        Surat::findOrFail($id)->delete();
    }
}
