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

        // Check if piket already exists for this day and branch
        $existingPiket = Piket::where('hari', $data['hari'])
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

    /**
     * Delete a piket record along with its participant relationships
     *
     * @param int $id The ID of the piket to delete
     * @return mixed API response
     */
    public function deletePiket(int $id)
    {
        $id_cabang = auth('sanctum')->user()->id_cabang_aktif;
        
        // Find the piket and ensure it belongs to the current branch
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
        
        // Delete the piket (relationships will be deleted due to database cascade or by the model event)
        $this->piketInterface->delete($id);
        
        return Api::response(
            null,
            'Data Piket Berhasil Dihapus',
            Response::HTTP_OK
        );
    }
    
    /**
     * Remove a specific participant from a piket schedule
     *
     * @param int $piketId The ID of the piket
     * @param int $pesertaId The ID of the participant to remove
     * @return mixed API response
     */
    public function removePesertaFromPiket(int $piketId, int $pesertaId)
    {
        $id_cabang = auth('sanctum')->user()->id_cabang_aktif;
        
        // Find the piket and ensure it belongs to the current branch
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
        
        // Detach only the specified participant
        $piket->peserta()->detach($pesertaId);
        
        // Reload the piket with its participants
        $piket->load('peserta');
        
        return Api::response(
            PiketResource::make($piket),
            'Peserta berhasil dihapus dari jadwal piket',
            Response::HTTP_OK
        );
    }
}