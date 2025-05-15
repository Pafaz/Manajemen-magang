<?php

namespace App\Services;

use Carbon\Carbon;
use App\Helpers\Api;
use App\Models\RekapKehadiran;
use Illuminate\Support\Facades\DB;
use App\Interfaces\AbsensiInterface;
use App\Interfaces\KehadiranInterface;
use App\Interfaces\RekapKehadiranInterface;
use Symfony\Component\HttpFoundation\Response;

class KehadiranService
{
    public const METODE_ONLINE = 'online';
    public const METODE_RFID = 'rfid';

    private JamKantorService $jamKantorService;
    private AbsensiInterface $absensiInterface;
    private KehadiranInterface $kehadiranInterface;
    private RekapKehadiranService $rekapKehadiranService; 
    public function __construct(
        JamKantorService $jamKantorService, 
        AbsensiInterface $absensiInterface,
        RekapKehadiranService $rekapKehadiranService,
        KehadiranInterface $kehadiranInterface)
    {
        $this->absensiInterface = $absensiInterface;
        $this->jamKantorService = $jamKantorService;
        $this->kehadiranInterface = $kehadiranInterface;
        $this->rekapKehadiranService = $rekapKehadiranService;
    }

    public function getKehadiran()
    {

        $Kehadiran = $this->kehadiranInterface->getAll();
        $Absensi = $this->absensiInterface->getAll();
        $rekap = $this->rekapKehadiranService->getRekap();

        if (!$Kehadiran) {
            return Api::response(null, 'Kehadiran tidak ditemukan', Response::HTTP_NOT_FOUND);
        }
        $data = [
            'kehadiran' => $Kehadiran,
            'rekap' => $rekap,
            'absensi' => $Absensi
        ];

        return Api::response($data, 'Berhasil mengambil semua data kehadiran', Response::HTTP_OK);
    }

    public function simpanKehadiran()
    {
        DB::beginTransaction();
        try {
            $user = auth('sanctum')->user();
            $peserta = $user->peserta;

            if (!$peserta) {
                return Api::response(null, 'Peserta tidak ditemukan.', Response::HTTP_FORBIDDEN);
            }

            $jamSekarang = Carbon::now('Asia/Jakarta')->format('H:i:s');
            $tanggalHariIni = Carbon::now('Asia/Jakarta')->format('Y-m-d');

            $jamKantor = $this->jamKantorService->getJamKantorToday();
            if (!$jamKantor) {
                return Api::response(null, 'Jam kantor untuk hari ini belum diatur.', Response::HTTP_NOT_FOUND);
            }

            // Cek apakah peserta sedang izin/sakit
            $izin = $this->absensiInterface->findByDate($peserta->id, $tanggalHariIni);
            if ($izin) {
                return Api::response(null, 'Anda sudah absen hari ini (izin/sakit).', Response::HTTP_FORBIDDEN);
            }

            $kehadiranHariIni = $this->kehadiranInterface->findByDate($peserta->id, $tanggalHariIni);
            $kehadiran = null;

            if (!$kehadiranHariIni) {
                // === ABSEN MASUK ===
                if ($jamSekarang >= $jamKantor->awal_masuk && $jamSekarang <= $jamKantor->akhir_masuk) {
                    // Hitung apakah terlambat
                    $terlambat = $jamSekarang > $jamKantor->awal_masuk;
                    $kehadiran = $this->kehadiranInterface->create([
                        'id_peserta' => $peserta->id,
                        'tanggal' => $tanggalHariIni,
                        'jam_masuk' => $jamSekarang,
                        'metode' => self::METODE_ONLINE,
                        'status_kehadiran' => $terlambat ? 1 : 0
                    ]);
                    $this->rekapKehadiranService->updateRekapHarian($peserta->id, $tanggalHariIni, $terlambat);
                }
                // === TERLAMBAT ABSEN, DICATAT ALFA ===
                elseif ($jamSekarang > $jamKantor->akhir_masuk && $jamSekarang >= $jamKantor->awal_istirahat) {
                    $absensi = $this->absensiInterface->create([
                        'id_peserta' => $peserta->id,
                        'tanggal' => $tanggalHariIni,
                        'status' => 'alfa'
                    ]);
                    $this->rekapKehadiranService->updateRekapAbsensi($peserta->id, $tanggalHariIni, 'alfa');
                    DB::commit();
                    return Api::response($absensi, 'Anda tidak absen masuk dan dianggap alfa.', Response::HTTP_OK);
                }
                else {
                    return Api::response(null, 'Saat ini bukan waktu yang valid untuk absen masuk.', Response::HTTP_FORBIDDEN);
                }
            } else {
                // === SESI ISTIRAHAT, KEMBALI, PULANG ===
                if (!$kehadiranHariIni->jam_istirahat && $jamSekarang >= $jamKantor->awal_istirahat && $jamSekarang <= $jamKantor->akhir_istirahat) {
                    $kehadiran = $this->kehadiranInterface->update($kehadiranHariIni->id, ['jam_istirahat' => $jamSekarang]);
                } elseif (!$kehadiranHariIni->jam_kembali && $jamSekarang >= $jamKantor->awal_kembali && $jamSekarang <= $jamKantor->akhir_kembali) {
                    $kehadiran = $this->kehadiranInterface->update($kehadiranHariIni->id, ['jam_kembali' => $jamSekarang]);
                } elseif (!$kehadiranHariIni->jam_pulang && $jamSekarang >= $jamKantor->awal_pulang && $jamSekarang <= $jamKantor->akhir_pulang) {
                    $kehadiran = $this->kehadiranInterface->update($kehadiranHariIni->id, ['jam_pulang' => $jamSekarang]);
                }
            }

            if ($kehadiran) {
                DB::commit();
                return Api::response($kehadiran, 'Berhasil mencatat absensi.', Response::HTTP_OK);
            } else {
                DB::rollBack();
                return Api::response(null, 'Semua sesi kehadiran sudah diisi atau waktu tidak valid.', Response::HTTP_FORBIDDEN);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return Api::response(null, $th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
