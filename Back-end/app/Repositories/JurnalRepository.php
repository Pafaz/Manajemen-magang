<?php

namespace App\Repositories;

use App\Interfaces\JurnalInterface;
use App\Models\Jurnal;
use Illuminate\Database\Eloquent\Collection;

class JurnalRepository implements JurnalInterface
{
    public function getAll(): Collection
    {
        return Jurnal::where('id_peserta', auth('sanctum')->user()->peserta->id)->get();
    }

    public function find(int $id): ?Jurnal
    {
        return Jurnal::findOrFail($id)->first();
    }

    public function firstOrCreate(array $attributes): Jurnal
    {
        return Jurnal::firstOrCreate($attributes);
    }


    public function create(array $data): ?Jurnal
    {
        return Jurnal::create($data);
    }

    public function update(int $id, array $data): Jurnal
    {
        $jurnal = Jurnal::findOrFail($id);
        $jurnal->update($data);
        return $jurnal;
    }

    public function delete(int $id): void
    {
        Jurnal::findOrFail($id)->delete();
    }
}
