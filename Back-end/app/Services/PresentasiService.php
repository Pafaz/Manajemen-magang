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

    public function createJadwalPresentasi(array $data)
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

            $presentasi = $this->jadwalPresentasiInterface->create($data);

            // dd($presentasi);

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
}