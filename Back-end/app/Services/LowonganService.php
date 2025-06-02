<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CabangInterface;
use App\Interfaces\LowonganInterface;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\LowonganResource;
use App\Http\Resources\LowonganPageResource;
use App\Http\Resources\LowonganDetailResource;
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
        $cachekey = 'lowongan';

        $data = Cache::remember($cachekey, 3600, function () {
            $lowongan = $this->lowonganInterface->getAll();

            return $lowongan->map(function ($lowongan) {
                $totalPeserta = $this->magangService->countPendaftar($lowongan->id);
                $lowongan->totalPeserta = $totalPeserta;
                return $lowongan;
            });
        });

        return Api::response(          
            LowonganPageResource::collection($data),
            'Lowongan Berhasil ditampilkan'
        );
    }


    public function getLowonganByPerusahaan()
    {
        $user = auth('sanctum')->user();
        $cacheKey = 'lowongan_perusahaan_'.$user->perusahaan->id;

        $data = Cache::remember($cacheKey,3600, function () use ($user) {
            return $this->lowonganInterface->getByPerusahaan($user->perusahaan->id);
        });
        
        return Api::response(
            LowonganResource::collection($data),
            'Lowongan '.$user->nama.' Berhasil ditampilkan'
        );
    }

    public function getLowonganById($id)
    {
        $cacheKey = 'lowongan_' . $id;

        $data = Cache::remember($cacheKey, 3600, function () use ($id) {
            $data = $this->lowonganInterface->find($id);

            if (!$data) {
                return null;
            }

            $totalPeserta = $this->magangService->countPendaftar($id);
            $data->totalPeserta = $totalPeserta;

            return $data;
        });

        if (!$data) {
            return Api::response(
                null,
                'Lowongan tidak ditemukan',
                Response::HTTP_NOT_FOUND
            );
        }

        return Api::response(
            LowonganDetailResource::collection([$data]),
            'Lowongan Berhasil ditampilkan'
        );
    }

    public function simpanLowongan(int $id = null, array $data)
    {
        $user = auth('sanctum')->user();
        $perusahaan = $user->perusahaan;

        if (!$id) {
            if (!isset($data['id_cabang']) || !isset($data['id_divisi'])) {
                return Api::response(null, 'id_cabang dan id_divisi harus ada', Response::HTTP_BAD_REQUEST);
            }

            $cabang = $this->cabangInterface->find($data['id_cabang'], $perusahaan->id);

            if (!$cabang || !$cabang->divisi()->where('id', $data['id_divisi'])->exists()) {
                return Api::response(null, 'Cabang atau divisi tidak valid untuk perusahaan ini', Response::HTTP_FORBIDDEN);
            }
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
                Cache::forget('lowongan_'. $id);
                Cache::forget('lowongan_perusahaan'. $perusahaan->id);

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

                Cache::forget('lowongan_perusahaan'. $perusahaan->id);
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
            Cache::forget('lowongan_'. $id);
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