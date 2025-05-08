<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\LowonganInterface;
use App\Http\Resources\LowonganResource;
use Symfony\Component\HttpFoundation\Response;

class LowonganService
{
    private LowonganInterface $lowonganInterface;
    private MagangService $magangService;

    public function __construct(LowonganInterface $lowonganInterface, MagangService $magangService)
    {
        $this->lowonganInterface = $lowonganInterface;
        $this->magangService = $magangService;
    }

    public function getAllLowongan()
    {
        $data = $this->lowonganInterface->getAll($id = null);
        return Api::response(
            LowonganResource::collection($data),
            'Lowongan Berhasil ditampilkan'
        );
    }

    public function getLowonganById($id)
    {
        $data = $this->lowonganInterface->find($id);

        if (!$data) {
            return Api::response(
                null,
                'Lowongan tidak ditemukan',
                Response::HTTP_NOT_FOUND
            );
        }

        $totalPeserta = $this->magangService->countPendaftar($id);

        $data->totalPeserta = $totalPeserta;

        return Api::response(
            LowonganResource::collection([$data]),
            'Lowongan Berhasil ditampilkan'
        );
    }

    public function simpanLowongan(int $id = null, array $data)
    {
        $id_perusahaan = auth('sanctum')->user()->perusahaan->id;
        DB::beginTransaction(); 
    
        try {
            if ($id) {
                $lowongan = $this->lowonganInterface->find($id);
    
                if (!$lowongan) {
                    return Api::response(
                        null,
                        'Lowongan tidak ditemukan',
                        Response::HTTP_NOT_FOUND
                    );
                }
    
                $lowongan = $this->lowonganInterface->update($id, $data);
            } else {
                $lowongan = $this->lowonganInterface->create([
                    'id_perusahaan' => $id_perusahaan,
                    'id_cabang' => $data['id_cabang'],
                    'id_divisi' => $data['id_divisi'],
                    'tanggal_mulai' => $data['tanggal_mulai'],
                    'tanggal_selesai' => $data['tanggal_selesai'],
                    'durasi' => $data['durasi'],
                    'max_kuota' => $data['max_kuota'],
                    'requirement' => $data['requirement'],
                    'jobdesc' => $data['jobdesc'],
                    'status' => true
                ]);
    
                if (!$lowongan) {
                    return Api::response(
                        null,
                        'Failed to create Lowongan.',
                        Response::HTTP_INTERNAL_SERVER_ERROR
                    );
                }
            }
    
            DB::commit();
    
            return Api::response(
                LowonganResource::make($lowongan),
                $id ? 'Berhasil Mengubah Lowongan' : 'Berhasil Membuat Lowongan',
                $id ? Response::HTTP_OK : Response::HTTP_CREATED
            );
    
        } catch (\Exception $e) {
            DB::rollBack();
            return Api::response(
                null,
                'Terjadi kesalahan: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    
    public function tutupLowongan($id)
    {
        $lowongan = $this->lowonganInterface->find($id);
    
        if (!$lowongan) {
            return Api::response(
                null,
                'Lowongan tidak ditemukan',
                Response::HTTP_NOT_FOUND
            );
        }
    
        DB::beginTransaction();
    
        try {
            $data = ['status' => false];
    
            $updatedLowongan = $this->lowonganInterface->update($id, $data);
    
            DB::commit();
    
            return Api::response(
                LowonganResource::make($updatedLowongan),
                'Lowongan berhasil ditutup',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return Api::response(
                null,
                'Gagal menutup lowongan: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}