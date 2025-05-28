<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\RekapKehadiran;
use Illuminate\Support\Facades\DB;
use App\Interfaces\RekapKehadiranInterface;
use Illuminate\Database\Eloquent\Collection;

class RekapKehadiranRepository implements RekapKehadiranInterface
{
    public function get()
    {
        return RekapKehadiran::where('id_peserta', auth('sanctum')->user()->peserta->id)->first();
    }

    public function getByCabang($id_cabang): Collection
    {
        return RekapKehadiran::with(['peserta.magangAktif.lowongan'])
            ->whereHas('peserta.magangAktif.lowongan', function ($query) use ($id_cabang) {
                $query->where('id_cabang', $id_cabang);
            })
            ->get();
    }

    public function getByCabangPerBulan($id_cabang): Collection
    {
        return RekapKehadiran::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as bulan"),
                DB::raw('SUM(total_hadir) as total_hadir'),
                DB::raw('SUM(total_izin) as total_izin'),
                DB::raw('SUM(total_alpha) as total_alpha'),
                DB::raw('SUM(total_terlambat) as total_terlambat')
            )
            ->whereHas('peserta.magangAktif.lowongan', function ($query) use ($id_cabang) {
                $query->where('id_cabang', $id_cabang);
            })
            ->whereBetween('created_at', [
                Carbon::now()->subMonths(11)->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
    }

    public function findOrCreateByPeserta( $peserta_id)
    {
        return RekapKehadiran::firstOrCreate([
            'id_peserta' => $peserta_id,
        ]);
    }

    public function find(int $id): ? RekapKehadiran
    {
        return RekapKehadiran::findOrFail($id)->first();
    }

    public function create(array $data): ? RekapKehadiran
    {
        return RekapKehadiran::firstOrCreate( $data);
    }

    public function update(int $id, array $data): RekapKehadiran
    {
        $category = RekapKehadiran::findOrFail($id);
        $category->update($data);

        return $category;
    }

    public function delete(int $id): void
    {
        RekapKehadiran::findOrFail($id)->delete();
    }
}
