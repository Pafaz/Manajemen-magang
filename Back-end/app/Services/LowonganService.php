<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Support\Facades\DB;
use App\Interfaces\LowonganInterface;
use App\Http\Resources\LowonganResource;
use Symfony\Component\HttpFoundation\Response;

class LowonganService
{
    private LowonganInterface $lowonganInterface;

    public function __construct(LowonganInterface $lowonganInterface)
    {
        $this->lowonganInterface = $lowonganInterface;
    }

    public function getAllLowongan()
    {
        $data = $this->lowonganInterface->getAll($id = null);  // Tidak perlu $id jika getAll tanpa filter
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

        return Api::response(
            LowonganResource::collection([$data]),
            'Lowongan Berhasil ditampilkan'
        );
    }

    public function createLowongan(array $data)
    {
        DB::beginTransaction();

        try {
            $id_perusahaan = auth('sanctum')->user()->perusahaan->id;

            $lowongan = $this->lowonganInterface->create([
                'id_perusahaan' => $id_perusahaan,
                'id_cabang' => $data['id_cabang'],
                'id_divisi' => $data['id_divisi'],
                'tanggal_mulai' => $data['tanggal_mulai'],
                'tanggal_selesai' => $data['tanggal_selesai'],
                'durasi' => $data['durasi'],
                'max_kuota' => $data['max_kuota'],
                'requirement' => $data['requirement'],
                'jobdesc' => $data['jobdesc']
            ]);

            if (!$lowongan) {
                return Api::response(
                    null,
                    'Failed to create Lowongan.',
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            DB::commit();
            return Api::response(
                LowonganResource::make($lowongan),
                'Berhasil Membuat Lowongan',
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return Api::response(
                null,
                'Failed to create Lowongan: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function updateLowongan(int $id, array $data)
    {
        $lowongan = $this->lowonganInterface->find($id);

        if (!$lowongan) {
            return Api::response(
                null,
                'Lowongan tidak ditemukan',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        DB::beginTransaction();

        try {
            $updatedLowongan = $this->lowonganInterface->update($id, $data);

            DB::commit();

            return Api::response(
                LowonganResource::make($updatedLowongan),
                'Lowongan Berhasil diperbarui',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return Api::response(
                null,
                'Failed to update Lowongan: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deleteLowongan($id)
    {
        $lowongan = $this->lowonganInterface->find($id);

        if (!$lowongan) {
            return Api::response(
                null,
                'Lowongan tidak ditemukan',
                Response::HTTP_NOT_FOUND
            );
        }

        $this->lowonganInterface->delete($id);

        return Api::response(
            null,
            'Berhasil menghapus Lowongan',
            Response::HTTP_OK
        );
    }
}