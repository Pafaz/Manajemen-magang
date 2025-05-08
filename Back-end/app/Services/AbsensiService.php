<?php

namespace App\Services;

use Carbon\Carbon;
use App\Helpers\Api;
use App\Interfaces\JurnalInterface;
use App\Interfaces\AbsensiInterface;
use App\Http\Resources\JurnalResource;
use Symfony\Component\HttpFoundation\Response;

class AbsensiService
{

    private JamKantorService $jamKantorService;
    private AbsensiInterface $absensiInterface;
    public function __construct(JamKantorService $jamKantorService, AbsensiInterface $absensiInterface)
    {
        $this->absensiInterface = $absensiInterface;
        $this->jamKantorService = $jamKantorService;
    }

    public function getAbsensi()
    {

        $Absensi = $this->absensiInterface->getAll();
        if (!$Absensi) {
            return Api::response(null, 'Absensi tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return Api::response($Absensi, 'Berhasil mengambil semua data absensi', Response::HTTP_OK);
    }

    public function simpanAbsensi()
    {
        $user = auth('sanctum')->user();
        $peserta = $user->peserta;

        // if (!$peserta || !$peserta->id || !$peserta->id_cabang_aktif) {
        //     return Api::response(null, 'Peserta belum melengkapi profil atau belum terdaftar magang.', Response::HTTP_FORBIDDEN);
        // }

        $jamSekarang = Carbon::now('Asia/Jakarta')->format('H:i:s');
        $tanggalHariIni = date('Y-m-d');

        $jamKantor = $this->jamKantorService->getJamKantorToday();
        // dd($jamKantor);
        if (!$jamKantor) {
            return Api::response(null, 'Jam kantor untuk hari ini belum diatur.', Response::HTTP_NOT_FOUND);
        }

        $absensiHariIni = $this->absensiInterface->findByDate($peserta->id, $tanggalHariIni);

        // Absen pertama kali (masuk)
        if (!$absensiHariIni) {
            if ($jamSekarang >= $jamKantor->awal_masuk && $jamSekarang <= $jamKantor->akhir_masuk) {
                $terlambat = $jamSekarang > $jamKantor->akhir_masuk;
                $status = $terlambat ? 'terlambat' : 'hadir';
                // dd($peserta->id);
                $absensi = $this->absensiInterface->create([
                    'id_peserta' => $peserta->id,
                    'tanggal'    => $tanggalHariIni,
                    'masuk'      => $jamSekarang,
                    'status'     => $status,
                ]);
            } else {
                return Api::response(null, 'Saat ini bukan waktu yang valid untuk absen masuk.', Response::HTTP_FORBIDDEN);
            }

        // Sudah pernah absen hari ini
    } else {
        $absensi = null;
    
        if (!$absensiHariIni->istirahat && $jamSekarang >= $jamKantor->awal_istirahat && $jamSekarang <= $jamKantor->akhir_istirahat) {
            $absensi = $this->absensiInterface->update($absensiHariIni->id, ['istirahat' => $jamSekarang]);
        } elseif (!$absensiHariIni->kembali && $jamSekarang >= $jamKantor->awal_kembali && $jamSekarang <= $jamKantor->akhir_kembali) {
            $absensi = $this->absensiInterface->update($absensiHariIni->id, ['kembali' => $jamSekarang]);
        } elseif (!$absensiHariIni->pulang && $jamSekarang >= $jamKantor->awal_pulang && $jamSekarang <= $jamKantor->akhir_pulang) {
            $absensi = $this->absensiInterface->update($absensiHariIni->id, ['pulang' => $jamSekarang]);
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
