<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\DetailJadwalPresentasiResource;
use Illuminate\Support\Facades\DB;
use App\Interfaces\PresentasiInterface;
use App\Http\Resources\PresentasiResource;
use App\Interfaces\JadwalPresentasiInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\JadwalPresentasiResource;

class PresentasiService
{
    private JadwalPresentasiInterface $jadwalPresentasiInterface;
    Private PresentasiInterface $presentasiInterface;

    public function __construct(PresentasiInterface $presentasiInterface, JadwalPresentasiInterface $jadwalPresentasiInterface)
    {
        $this->presentasiInterface = $presentasiInterface;
        $this->jadwalPresentasiInterface = $jadwalPresentasiInterface;
    }

    public function getPresentasi()
    {
        return $this->presentasiInterface->getAll();
    }

    //For Mentor
    public function createJadwalPresentasi(array $data)
    {
        DB::beginTransaction();
        try {
            $id_mentor = auth('sanctum')->user()->mentor->id;

            $data['id_mentor'] = $id_mentor;

            $data['status'] = 'dijadwalkan';

            if ($data['tipe'] === 'online') {
                unset($data['lokasi']);
            }

            if ($data['tipe'] === 'offline') {
                unset($data['link_zoom']);
            }

            $presentasi = $this->jadwalPresentasiInterface->create($data);

            DB::commit();

            return Api::response( JadwalPresentasiResource::make($presentasi), 
            'Jadwal Presentasi berhasil dibuat',
            Response::HTTP_CREATED
            );
            
        }  catch (\Exception $e) {
            DB::rollBack();
            return Api::response(null, 'Gagal Menyimpan jadwal presentasi'. $e->getMessage());
        }
    }

    public function updateJadwalPresentasi(int $id, array $data)
    {
        DB::beginTransaction();
        try {
            $id_mentor = auth('sanctum')->user()->mentor->id;

            $data['id_mentor'] = $id_mentor;

            if ($data['tipe'] === 'online') {
                unset($data['lokasi']);
            }

            if ($data['tipe'] === 'offline') {
                unset($data['link_zoom']);
            }

            $jadwalPresentasi = $this->jadwalPresentasiInterface->find($id);
            if (!$jadwalPresentasi) {
                return Api::response(null, 'Jadwal presentasi tidak ditemukan', Response::HTTP_NOT_FOUND);
            }

            $updatedJadwal = $this->jadwalPresentasiInterface->update($id, $data);

            DB::commit();

            return Api::response(
                JadwalPresentasiResource::make($updatedJadwal),
                'Jadwal Presentasi berhasil diperbarui',
                Response::HTTP_OK
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return Api::response(null, 'Gagal memperbarui jadwal presentasi: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getDetailJadwalPresentasi($id)
    {
        $data = $this->jadwalPresentasiInterface->find($id);

        return Api::response(
            DetailJadwalPresentasiResource::make($data),
            'Data Presentasi Berhasil ditampilkan',
        );
    }

    public function getJadwalPresentasi()
    {
        $id_mentor = auth('sanctum')->user()->mentor->id;

        $nama_mentor = auth('sanctum')->user()->nama;

        $data = $this->jadwalPresentasiInterface->getAll($id_mentor);

        return Api::response(
            JadwalPresentasiResource::collection($data),
            'Jadwal Presentasi '. $nama_mentor . ' berhasil ditampilkan'
        );
    }

    public function getJadwalPresentasiPeserta()
    {
        $id_mentor = auth('sanctum')->user()->peserta->magang->id_mentor;

        $data = $this->jadwalPresentasiInterface->getAll($id_mentor);

        return Api::response(
            JadwalPresentasiResource::collection($data),
            'Jadwal Presentasi berhasil ditampilkan'
        );
    }

    //For Peserta
    public function applyPresentasi(array $data)
    {
        $peserta = auth('sanctum')->user()->peserta;

        $existingPresentasi = $peserta->presentasi->where('id_jadwal_presentasi', $data['id_jadwal_presentasi'])->first();
        if ($existingPresentasi) {
            return Api::response(null, 'Anda sudah mengajukan presentasi untuk jadwal ini', Response::HTTP_FORBIDDEN);
        }

        $projek = $peserta->route->where('selesai', null)->first()->kategoriProyek->nama;
        $data['id_peserta'] = $peserta->id;
        $data['projek'] = $projek;
        $presentasi = $this->presentasiInterface->create($data);
        return Api::response(
            $presentasi,
            'Berhasil Apply Presentasi',
        );
    }


    public function getRiwayatPresentasi()
    {
        $id_peserta = auth('sanctum')->user()->peserta->id;

        $riwayat = $this->presentasiInterface->getPresentasiPeserta($id_peserta);

        // dd($riwayat);

        return Api::response(
            PresentasiResource::collection($riwayat),
            'Riwayat Presentasi Berhasil ditampilkan',
        );
    }

    public function updateRiwayat( array $data, $id)
    {
        // dd($data, $id);
        $nama = $this->presentasiInterface->find($id)->peserta->user->nama;

        // dd($nama);

        $this->presentasiInterface->update($id,  $data);

        if ($data['status'] === 1) {
            return Api::response(
                null,
                $nama.' telah hadir presentasi',
            );
        } else {
            return Api::response(
                null,
                $nama.' tidak hadir presentasi',
            );
        }
    }
}