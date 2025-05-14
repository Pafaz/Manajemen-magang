<?php

namespace App\Services;

use Carbon\Carbon;
use App\Helpers\Api;
use App\Interfaces\AbsensiInterface;
use App\Interfaces\KehadiranInterface;
use Symfony\Component\HttpFoundation\Response;

class AbsensiService
{

    private JamKantorService $jamKantorService;
    private AbsensiInterface $absensiInterface;
    private KehadiranInterface $kehadiranInterface;
    private MagangService $magangService;
    private RekapKehadiranService $rekapKehadiranService;
    public function __construct(
        JamKantorService $jamKantorService, 
        AbsensiInterface $absensiInterface, 
        KehadiranInterface $kehadiranInterface,
        MagangService $magangService,
        RekapKehadiranService $rekapKehadiranService
        )
    {
        $this->absensiInterface = $absensiInterface;
        $this->jamKantorService = $jamKantorService;
        $this->kehadiranInterface = $kehadiranInterface;
        $this->magangService = $magangService;
        $this->rekapKehadiranService = $rekapKehadiranService;
    }

    public function getAbsensi()
    {

        $Absensi = $this->absensiInterface->getAll();
        if (!$Absensi) {
            return Api::response(null, 'Absensi tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return Api::response($Absensi, 'Berhasil mengambil semua data absensi', Response::HTTP_OK);
    }

    public function generateAlfaPesertaHarian(Carbon $tanggal)
    {
        $pesertas = $this->magangService->getAllPesertaMagang();
        
        $jamKantor = $this->jamKantorService->getJamKantorToday();
        if (!$jamKantor || !$jamKantor->status) {
            return; // Tidak dianggap hari kerja, lewati
        }

        foreach ($pesertas as $peserta) {
            // Cek apakah sudah ada absensi atau izin
            $hasAbsen = $this->kehadiranInterface->findByDate($peserta->id, $tanggal->format('Y-m-d'));
            $hasIzin  = $this->absensiInterface->findByDate($peserta->id, $tanggal->format('Y-m-d'));

            if (!$hasAbsen && !$hasIzin) {
                // Buat absensi status alfa
                $this->absensiInterface->create([
                    'id_peserta' => $peserta->id,
                    'tanggal'    => $tanggal->format('Y-m-d'),
                    'status'     => 'alfa'
                ]);

                // Update rekap
                $this->rekapKehadiranService->updateRekapAbsensi($peserta, $tanggal, 'alfa');
            }
        }
    }

    public function buatAbsensiDenganRekap( $idPeserta, Carbon $tanggal, string $status)
    {
        $this->absensiInterface->create([
            'id_peserta' => $idPeserta,
            'tanggal'    => $tanggal->format('Y-m-d'),
            'status'     => $status,
        ]);

        $this->rekapKehadiranService->updateRekapAbsensi($idPeserta, $tanggal, $status);
    }


}
