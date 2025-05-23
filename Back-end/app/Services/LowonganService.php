<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Support\Facades\DB;
use App\Interfaces\LowonganInterface;
use App\Http\Resources\LowonganResource;
use App\Interfaces\CabangInterface;
use Symfony\Component\HttpFoundation\Response;

class LowonganService
{
    private LowonganInterface $lowonganInterface;
    private MagangService $magangService;

    private CabangInterface $cabangInterface;

    public function __construct(LowonganInterface $lowonganInterface, MagangService $magangService, CabangInterface $cabangInterface)
    {
        $this->lowonganInterface = $lowonganInterface;
        $this->magangService = $magangService;
        $this->cabangInterface = $cabangInterface;
    }

    public function getAllLowongan()
    {
        $data = $this->lowonganInterface->getAll();
        return Api::response(          
            LowonganResource::collection($data),
            'Lowongan Berhasil ditampilkan'
        );
    }

    public function getLowonganByPerusahaan()
    {
        $user = auth('sanctum')->user();
        $data = $this->lowonganInterface->getByPerusahaan($user->perusahaan->id);
        return Api::response(
            LowonganResource::collection($data),
            'Lowongan '.$user->nama.' Berhasil ditampilkan'
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
        $user = auth('sanctum')->user();
        $perusahaan = $user->perusahaan;
        $cabang = $this->cabangInterface->find($data['id_cabang'], $perusahaan->id);
    
        if (!$cabang || !$cabang->divisi()->where('id', $data['id_divisi'])->exists()) {
            return Api::response(null, 'Cabang atau divisi tidak valid untuk perusahaan ini', Response::HTTP_FORBIDDEN);
        }
    
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
                if (!$perusahaan->cabang()->where('id', $data['id_cabang'])->exists()) {
                    return Api::response(null, 'Cabang tidak valid untuk perusahaan ini', Response::HTTP_FORBIDDEN);
                }
    
                $lowongan = $this->lowonganInterface->create([
                    'id_perusahaan' => $perusahaan->id,
                    'id_cabang' => $data['id_cabang'],
                    'id_divisi' => $data['id_divisi'],
                    'tanggal_mulai' => $data['tanggal_mulai'],
                    'tanggal_selesai' => $data['tanggal_selesai'],
                    'max_kuota' => $data['max_kuota'],
                    'requirement' => $data['requirement'],
                    'jobdesc' => $data['jobdesc'],
                    'status' => true
                ]);
            }
    
            if (!$lowongan) {
                throw new \Exception('Gagal membuat atau memperbarui lowongan.');
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