<?php

namespace App\Services;

use App\Interfaces\JurnalInterface;
use App\Interfaces\MagangInterface;
use App\Interfaces\PesertaInterface;
use App\Interfaces\RekapKehadiranInterface;

class RekapPesertaService
{
    private JurnalInterface $jurnalInterface;
    private MagangInterface $magangInterface;
    private RekapKehadiranInterface $rekapKehadiranInterface;
    private PesertaInterface $pesertaInterface;
    private PesertaService $pesertaService;

    public function __construct(MagangInterface $magangInterface, JurnalInterface $jurnalInterface, RekapKehadiranInterface $rekapKehadiranInterface, PesertaInterface $pesertaInterface, PesertaService $pesertaService)
    {
        $this->jurnalInterface = $jurnalInterface;
        $this->magangInterface = $magangInterface;
        $this->rekapKehadiranInterface = $rekapKehadiranInterface;
        $this->pesertaInterface = $pesertaInterface;
        $this->pesertaService = $pesertaService;
    }

    public function simpanRekap()
    {
        $peserta = auth('sanctum')->user()->peserta;

        $kehadiran = $this->rekapKehadiranInterface->get();
        $perusahaan = $peserta->magang->lowongan->cabang->nama;
        $divisi = $peserta->magang->lowongan->divisi->nama;
        $route = $this->pesertaInterface->getRouteById($peserta->id);

        $bulanMulaiMagang = (int) date('m', strtotime($peserta->magang->mulai));
        $tahunMulaiMagang = (int) date('Y', strtotime($peserta->magang->mulai));

        $bulanSekarang = (int) date('m');
        $tahunSekarang = (int) date('Y');

        $jurnalPerTahun = [];
        for ($bulan = $bulanMulaiMagang; $bulan <= $bulanSekarang; $bulan++) {
            $rekapJurnal = $this->jurnalInterface->hitungJurnalPerBulan($peserta->id, $bulan, $tahunSekarang); // Menghitung jurnal
            $jurnalPerTahun[] = [
                'bulan' => $bulan,
                'jurnal_terisi' => $rekapJurnal['jurnal_terisi'],
                'jurnal_tidak_terisi' => $rekapJurnal['jurnal_tidak_terisi']
            ];
        }

        $rekap = [
            "kehadiran" => $kehadiran,
            "magang" => [
                "perusahaan"=> $perusahaan,
                "divisi"=> $divisi,
            ],
            "route" => $route,
            "jurnal" => $jurnalPerTahun
        ];

        return $rekap;
    }
}


