<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\PiketResource;
use App\Interfaces\PiketInterface;
use App\Models\Piket;
use Symfony\Component\HttpFoundation\Response;

class PiketService
{
    private PiketInterface $piketInterface;

    public function __construct(PiketInterface $piketInterface)
    {
        $this->piketInterface = $piketInterface;
    }

    public function getPiket()
    {
        $id_cabang = auth('sanctum')->user()->id_cabang_aktif;
        $data = $this->piketInterface->getAll($id_cabang);

        return Api::response(PiketResource::collection($data), 'Data Piket Berhasil Ditampilkan');
    }

    public function simpanPiket(array $data, $id = null)
    {
        $id_cabang = auth('sanctum')->user()->id_cabang_aktif;
        $data['id_cabang'] = $id_cabang;

        $existingPiket = Piket::where('hari', $data['hari'])
            ->where('shift', $data['shift'])
            ->where('id_cabang', $id_cabang)
            ->first();

        if ($existingPiket && $existingPiket->id != $id) {
            return Api::response(
                null,
                'Jadwal piket untuk hari ini sudah ada di cabang ini.',
                Response::HTTP_CONFLICT
            );
        }

        if ($id) {
            $piket = $this->piketInterface->update($id, $data);
        } else {
            $piket = $this->piketInterface->create($data);
        }

        return Api::response(
            PiketResource::make($piket),
            !$id ? 'Piket Berhasil Dibuat' : 'Piket Berhasil Diupdate',
            !$id ? Response::HTTP_CREATED : Response::HTTP_ACCEPTED
        );
    }

    public function deletePiket(int $id)
    {
        $id_cabang = auth('sanctum')->user()->id_cabang_aktif;
        
        $piket = Piket::where('id', $id)
            ->where('id_cabang', $id_cabang)
            ->first();
            
        if (!$piket) {
            return Api::response(
                null,
                'Data Piket tidak ditemukan',
                Response::HTTP_NOT_FOUND
            );
        }
        
        $this->piketInterface->delete($id);
        
        return Api::response(
            null,
            'Data Piket Berhasil Dihapus',
            Response::HTTP_OK
        );
    }

    public function removePesertaFromPiket(int $piketId, string $pesertaId)
    {
        $id_cabang = auth('sanctum')->user()->id_cabang_aktif;
        
        $piket = Piket::where('id', $piketId)
            ->where('id_cabang', $id_cabang)
            ->first();

        if (!$piket) {
            return Api::response(
                null,
                'Data Piket tidak ditemukan',
                Response::HTTP_NOT_FOUND
            );
        }
        
        $piket->peserta()->detach($pesertaId);
        
        $piket->load('peserta');
        
        return Api::response(
            PiketResource::make($piket),
            'Peserta berhasil dihapus dari jadwal piket',
            Response::HTTP_OK
        );
    }
}