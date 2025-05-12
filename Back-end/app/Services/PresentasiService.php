<?php

namespace App\Services;

use App\Helpers\Api;
use App\Interfaces\PresentasiInterface;

class PresentasiService
{
    Private PresentasiInterface $presentasiInterface;

    public function __construct(PresentasiInterface $presentasiInterface)
    {
        $this->presentasiInterface = $presentasiInterface;
    }

    public function getPresentasi()
    {
        return $this->presentasiInterface->getAll();
    }

    public function createPresentasi(array $data)
    {
        $id_mentor = auth('sanctum')->user()->id;
        $data['id_mentor'] = $id_mentor;
        $presentasi = $this->presentasiInterface->create($data);

        return Api::response($presentasi, 'Jadwal Presentasi berhasil dibuat');
    }

    // public function applyToPresentation($idJadwal)
    // {
    //     $jadwal = JadwalPresentasi::find($idJadwal);
        
    //     if ($jadwal->peserta()->count() >= $jadwal->kuota) {
    //         return response()->json(['message' => 'Kuota penuh'], 400);
    //     }

    //     $peserta = auth()->user(); // Asumsi menggunakan auth untuk mendapatkan peserta yang sedang login
    //     $jadwal->peserta()->create([
    //         'id_peserta' => $peserta->id,
    //         'status_kehadiran' => false, // Status awal 'belum hadir'
    //     ]);

    //     return response()->json(['message' => 'Pendaftaran berhasil']);
    // }

    // public function updateAttendance($idJadwal, $idPeserta, $status)
    // {
    //     $pesertaPresentasi = PesertaPresentasi::where('id_jadwal_presentasi', $idJadwal)
    //                                         ->where('id_peserta', $idPeserta)
    //                                         ->first();

    //     if (!$pesertaPresentasi) {
    //         return response()->json(['message' => 'Peserta tidak terdaftar'], 404);
    //     }

    //     $pesertaPresentasi->update([
    //         'status_kehadiran' => $status, // true untuk hadir, false untuk tidak hadir
    //     ]);

    //     return response()->json(['message' => 'Status kehadiran berhasil diperbarui']);
    // }


}