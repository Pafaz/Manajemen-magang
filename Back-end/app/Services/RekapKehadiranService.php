<?php

namespace App\Services;

use Carbon\Carbon;
use App\Interfaces\RekapKehadiranInterface;

class RekapKehadiranService
{
    private RekapKehadiranInterface $rekapKehadiranInterface;

    public function __construct(RekapKehadiranInterface $rekapKehadiranInterface)
    {
        $this->rekapKehadiranInterface = $rekapKehadiranInterface;
    }
    public function getRekap()
    {
        return $this->rekapKehadiranInterface->get();
    }
    // Untuk hadir
    public function updateRekapHarian($peserta,  $tanggal, bool $terlambat = false)
    {
        $rekap = $this->getOrCreateRekap($peserta, $tanggal);

        $rekap->total_hadir += 1;
        if ($terlambat) {
            $rekap->total_terlambat += 1;
        }

        $rekap->save();
    }

    // Untuk izin, sakit, alfa
    public function updateRekapAbsensi($peserta,  $tanggal, string $status)
    {
        $rekap = $this->getOrCreateRekap($peserta,  $tanggal);

        match ($status) {
            'izin' => $rekap->total_izin += 1,
            'alfa' => $rekap->total_alpha += 1,
            default => throw new \InvalidArgumentException("Status absensi tidak valid"),
        };

        $rekap->save();
    }

    // Utility agar tidak duplikasi
    private function getOrCreateRekap($peserta, $tanggal)
    {
        $tanggal = Carbon::parse($tanggal);
        return $this->rekapKehadiranInterface->findOrCreateByPeserta($peserta);
    }

}
