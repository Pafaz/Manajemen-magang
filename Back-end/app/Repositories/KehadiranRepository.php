<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Kehadiran;
use App\Interfaces\KehadiranInterface;
use Illuminate\Database\Eloquent\Collection;

class KehadiranRepository implements KehadiranInterface
{
    public function getAll(): Collection
    {
        return Kehadiran::all();
    }

    public function find(int $id): ? Kehadiran
    {
        return Kehadiran::findOrFail($id)->first();
    }

    public function create(array $data): ? Kehadiran
    {
        return Kehadiran::firstOrCreate( $data);
    }

    public function findByDate(string $idPeserta, $tanggal)
    {
        return Kehadiran::where('id_peserta', $idPeserta)
            ->where('tanggal', $tanggal)
            ->first();
    }

    public function update(int $id, array $data): Kehadiran
    {
        $kehadiran = Kehadiran::findOrFail($id);
        $kehadiran->update($data);
        return $kehadiran;
    }

    public function delete(int $id): void
    {
        Kehadiran::findOrFail($id)->delete();
    }
}
