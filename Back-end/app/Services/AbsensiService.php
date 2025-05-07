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

    // public function getJurnal($id = null)
    // {

    //     $jurnal = $id ? $this->jurnalInterface->find($id) : $this->jurnalInterface->getAll();
    //     if (!$jurnal) {
    //         return Api::response(null, 'Jurnal tidak ditemukan', Response::HTTP_NOT_FOUND);
    //     }

    //     $data = $id
    //         ? JurnalResource::make($this->jurnalInterface->find($id))
    //         : JurnalResource::collection($this->jurnalInterface->getAll());

    //     $message = $id
    //         ? 'Berhasil mengambil data jurnal'
    //         : 'Berhasil mengambil semua data jurnal';

    //     return Api::response($data, $message);
    // }

    public function simpanAbsensi()
    {
        $user = auth('sanctum')->user();
        $peserta = $user->peserta;

        if (!$peserta || !$peserta->id || !$peserta->id_cabang_aktif) {
            return Api::response(null, 'Peserta belum melengkapi profil atau belum terdaftar magang.', Response::HTTP_FORBIDDEN);
        }

        $hariIni = strtolower(Carbon::now()->translatedFormat('l')); // "senin", "selasa", ...
        $jamSekarang = now()->format('H:i:s');
        $tanggalHariIni = date('Y-m-d');

        // Ambil jam kantor hari ini
        $jamKantor = collect($this->jamKantorService->getJamKantor()['data'] ?? [])
            ->firstWhere('hari', $hariIni);

        if (!$jamKantor) {
            return Api::response(null, 'Jam kantor untuk hari ini belum diatur.', Response::HTTP_NOT_FOUND);
        }

        $absensiHariIni = $this->absensiInterface->findByDate($peserta->id, $tanggalHariIni);

        if (!$absensiHariIni) {
            if ($jamSekarang >= $jamKantor['awal_masuk'] && $jamSekarang <= $jamKantor['akhir_masuk']) {
                $status = $jamSekarang > $jamKantor['awal_masuk'] ? 'hadir' : 'hadir'; // atau 'terlambat'
                $absensi = $this->absensiInterface->create([
                    'id_peserta' => $peserta->id,
                    'tanggal'    => $tanggalHariIni,
                    'masuk'      => now(),
                    'status'     => $status,
                ]);
            } else {
                return Api::response(null, 'Saat ini bukan waktu yang valid untuk absen masuk.', Response::HTTP_FORBIDDEN);
            }
        } else {
            if (!$absensiHariIni->istirahat && $jamSekarang >= $jamKantor['awal_istirahat'] && $jamSekarang <= $jamKantor['akhir_istirahat']) {
                $absensi = $this->absensiInterface->update($absensiHariIni->id, ['istirahat' => now()]);
            } elseif (!$absensiHariIni->kembali && $jamSekarang >= $jamKantor['awal_kembali'] && $jamSekarang <= $jamKantor['akhir_kembali']) {
                $absensi = $this->absensiInterface->update($absensiHariIni->id, ['kembali' => now()]);
            } elseif (!$absensiHariIni->pulang && $jamSekarang >= $jamKantor['awal_pulang'] && $jamSekarang <= $jamKantor['akhir_pulang']) {
                $absensi = $this->absensiInterface->update($absensiHariIni->id, ['pulang' => now()]);
            } else {
                return Api::response(null, 'Semua sesi absensi sudah diisi atau waktu tidak valid.', Response::HTTP_FORBIDDEN);
            }
        }

        return Api::response($absensi, 'Berhasil melakukan absen', Response::HTTP_OK);
    }

}
