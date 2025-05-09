<?php

namespace App\Services;

use Carbon\Carbon;
use App\Helpers\Api;
use App\Models\RekapKehadiran;
use App\Interfaces\AbsensiInterface;
use App\Interfaces\KehadiranInterface;
use App\Interfaces\RekapKehadiranInterface;
use Symfony\Component\HttpFoundation\Response;

class KehadiranService
{

    private JamKantorService $jamKantorService;
    private AbsensiInterface $absensiInterface;
    private KehadiranInterface $kehadiranInterface;
    private RekapKehadiranInterface $rekapKehadiranInterface; 
    public function __construct(
        JamKantorService $jamKantorService, 
        AbsensiInterface $absensiInterface,
        RekapKehadiranInterface $rekapKehadiranInterface,
        KehadiranInterface $kehadiranInterface)
    {
        $this->absensiInterface = $absensiInterface;
        $this->jamKantorService = $jamKantorService;
        $this->kehadiranInterface = $kehadiranInterface;
        $this->rekapKehadiranInterface = $rekapKehadiranInterface;
    }

    public function getKehadiran()
    {

        $Kehadiran = $this->absensiInterface->getAll();
        if (!$Kehadiran) {
            return Api::response(null, 'Absensi tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return Api::response($Kehadiran, 'Berhasil mengambil semua data absensi', Response::HTTP_OK);
    }

    public function simpanKehadiran()
    {
        $user = auth('sanctum')->user();
        $peserta = $user->peserta;

        if (!$peserta || !$peserta->id || !$user->id_cabang_aktif) {
            return Api::response(null, 'Peserta belum melengkapi profil atau belum terdaftar magang.', Response::HTTP_FORBIDDEN);
        }

        $jamSekarang = Carbon::now('Asia/Jakarta')->format('H:i:s');
        $tanggalHariIni = date('Y-m-d');

        $jamKantor = $this->jamKantorService->getJamKantorToday();
        // dd($jamKantor);
        if (!$jamKantor) {
            return Api::response(null, 'Jam kantor untuk hari ini belum diatur.', Response::HTTP_NOT_FOUND);
        }

        $kehadiranHariIni = $this->kehadiranInterface->findByDate($peserta->id, $tanggalHariIni);
        if($kehadiranHariIni) {
            return Api::response(null, 'Anda sudah absen hari ini.', Response::HTTP_FORBIDDEN);
        }
        // Absen pertama kali (masuk)
        if (!$kehadiranHariIni) {
            if ($jamSekarang >= $jamKantor->awal_masuk && $jamSekarang <= $jamKantor->akhir_masuk) {
                // dd($peserta->id);
                $absensi = $this->kehadiranInterface->create([
                    'id_peserta' => $peserta->id,
                    'tanggal'    => $tanggalHariIni,
                    'jam_masuk'      => $jamSekarang,
                ]);
            } else {
                return Api::response(null, 'Saat ini bukan waktu yang valid untuk absen masuk.', Response::HTTP_FORBIDDEN);
            }

        // Sudah pernah absen hari ini
        } else {
            $absensi = null;
        
            if (!$kehadiranHariIni->istirahat && $jamSekarang >= $jamKantor->awal_istirahat && $jamSekarang <= $jamKantor->akhir_istirahat) {
                $absensi = $this->absensiInterface->update($kehadiranHariIni->id, ['jam_istirahat' => $jamSekarang]);
            } elseif (!$kehadiranHariIni->kembali && $jamSekarang >= $jamKantor->awal_kembali && $jamSekarang <= $jamKantor->akhir_kembali) {
                $absensi = $this->absensiInterface->update($kehadiranHariIni->id, ['jam_kembali' => $jamSekarang]);
            } elseif (!$kehadiranHariIni->pulang && $jamSekarang >= $jamKantor->awal_pulang && $jamSekarang <= $jamKantor->akhir_pulang) {
                $absensi = $this->absensiInterface->update($kehadiranHariIni->id, ['jam_pulang' => $jamSekarang]);
            }
        
            if ($absensi) {
                return Api::response($absensi, 'Berhasil melakukan absen', Response::HTTP_OK);
            } else {
                return Api::response(null, 'Semua sesi absensi sudah diisi atau waktu tidak valid.', Response::HTTP_FORBIDDEN);
            }
        }

        return Api::response($absensi, 'Berhasil melakukan absen', Response::HTTP_OK);
    }


}
