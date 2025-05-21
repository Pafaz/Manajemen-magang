<?php

namespace App\Services;

use Carbon\Carbon;
use App\Helpers\Api;
use App\Http\Resources\JurusanResource;
use App\Interfaces\RekapPerusahaanInterface;
    use App\Models\Perusahaan;
use App\Models\Cabang;
use App\Models\Magang;
use App\Models\Jurnal;
use App\Models\Peserta;
use App\Models\RekapPerusahaan;

class RekapPerusahaanService
{
    private RekapPerusahaanInterface $rekapPerusahaanInterface;

    public function __construct(RekapPerusahaanInterface $rekapPerusahaanInterface)
    {
        $this->rekapPerusahaanInterface = $rekapPerusahaanInterface;
    }

    public function getRekap()
    {
        return $this->rekapPerusahaanInterface->getAll();
    }
    function updateRekapPerusahaan()
    {
        $idPerusahaan = auth('sanctum')->user()->perusahaan->id;
        $totalCabang = Cabang::where('id_perusahaan', $idPerusahaan)->count();

        $totalPeserta = Magang::whereHas('lowongan', function($q) use ($idPerusahaan) {
            $q->where('id_perusahaan', $idPerusahaan);
        })->where('status', 'diterima')->count();

        $totalJurnal = Jurnal::whereHas('peserta.magang.lowongan', function ($q) use ($idPerusahaan) {
            $q->where('id_perusahaan', $idPerusahaan);
        })->count();

        $totalPendaftar = Magang::whereHas('lowongan', function($q) use ($idPerusahaan) {
            $q->where('id_perusahaan', $idPerusahaan);
        })->count();

        $data = RekapPerusahaan::updateOrCreate(
            ['id_perusahaan' => $idPerusahaan],
            [
                'total_cabang' => $totalCabang,
                'total_peserta' => $totalPeserta,
                'total_jurnal' => $totalJurnal,
                'total_pendaftar' => $totalPendaftar,
            ]
        );

        return Api::response(
            $data,
            'Rekap berhasil disimpan'
        );
    }

}
