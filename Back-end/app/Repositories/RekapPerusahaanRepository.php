<?php

namespace App\Repositories;

use App\Interfaces\RekapPerusahaanInterface;
use App\Models\RekapPerusahaan;
use Illuminate\Database\Eloquent\Collection;

class RekapPerusahaanRepository implements RekapPerusahaanInterface
{
    public function find($id_perusahaan): ? RekapPerusahaan
    {
        $rekap = RekapPerusahaan::where('id_perusahaan', $id_perusahaan)->first();
        $rekap['peserta'] = json_decode($rekap['peserta']);
        return $rekap;
    }

    public function create(array $data): ? RekapPerusahaan
    {
        return RekapPerusahaan::firstOrCreate( $data);
    }

    public function update($id_perusahaan, array $data): RekapPerusahaan
    {
        $data['peserta'] = json_encode($data['peserta']);
        $rekap = RekapPerusahaan::updateOrCreate(['id_perusahaan' => $id_perusahaan], $data);
        return $rekap;
    }

}
