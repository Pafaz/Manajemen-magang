<?php

namespace App\Repositories;

use App\Models\Jurnal;
use App\Models\Peserta;
use Illuminate\Support\Facades\DB;
use App\Interfaces\JurnalInterface;
use Illuminate\Database\Eloquent\Collection;

class JurnalRepository implements JurnalInterface
{
    public function getAll(): Collection
    {
        return Jurnal::with('peserta')->where('id_peserta', auth('sanctum')->user()->peserta->id)->get();
    }
    public function findByPesertaAndTanggal($idPeserta, $tanggal)
    {
        return Jurnal::where('id_peserta', $idPeserta)
            ->whereDate('tanggal', $tanggal)
            ->first();
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

    public function countByPerusahaan($id_perusahaan): int
    {
        return Jurnal::whereHas('peserta.magang.lowongan', function ($query) use ($id_perusahaan) {
            $query->where('id_perusahaan', $id_perusahaan);
        })->count();
    }

    public function hitungJurnalPerBulan($idPeserta, $bulan, $tahun)
    {
        $jurnalTerisi = Jurnal::where('id_peserta', $idPeserta)
                            ->whereMonth('tanggal', $bulan)
                            ->whereYear('tanggal', $tahun)
                            ->count();

        $jurnalTidakTerisi = $jurnalTerisi > 0 ? 0 : 1;

        return [
            'jurnal_terisi' => $jurnalTerisi,
            'jurnal_tidak_terisi' => $jurnalTidakTerisi
        ];
    }

    public function getRekapJurnalByPeserta(array $idPeserta)
    {
        return Jurnal::select(DB::raw("DATE(created_at) as tanggal"), 'id_peserta', 'judul')
            ->whereIn('id_peserta', $idPeserta)
            ->whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->get();
    }
}
