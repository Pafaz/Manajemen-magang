<?php

namespace App\Services;

use App\Helpers\Api;
use App\Interfaces\MagangInterface;
use App\Http\Resources\MagangResource;
use App\Http\Resources\JurusanResource;
use Symfony\Component\HttpFoundation\Response;

class MagangService
{
    private MagangInterface $MagangInterface;
    private FotoService $foto;

    public function __construct(MagangInterface $MagangInterface, FotoService $foto)
    {
        $this->MagangInterface = $MagangInterface;
        $this->foto = $foto;
    }

    public function getAllMagang()
    {
        $data = $this->MagangInterface->getAll();
        return Api::response(
            MagangResource::collection($data),
            'Magang Fetched Successfully', 
        );
    }

    public function applyMagang(array $data)
    {
        $peserta = auth('sanctum')->user()->peserta;
        // dd($peserta);
        $magang = $this->MagangInterface->create([
            'id_peserta' => $peserta->id,
            'id_lowongan' => $data['id_lowongan'],
            'tipe' => $data['tipe'],
            'mulai' => $data['mulai'],
            'selesai' => $data['selesai'],
            'status' => 'menunggu',
        ]);

        $files = [
            'surat_pernyataan_diri' => 'surat_pernyataan_diri',
            'surat_pernyataan_ortu' => 'surat_pernyataan_ortu',
        ];

        foreach ($files as $key => $type) {
            if (!empty($data[$key])) {
                $this->foto->createFoto($data[$key],  $magang->id, $type);
            }
        }
        return Api::response(
            MagangResource::make($magang),
            'Berhasil mengajukan magang',
            Response::HTTP_CREATED
        );
    }

    public function approvalMagang(int $id, array $data)
    {
        $magang = $this->MagangInterface->find($id);
        $magang->status = $data['status'];
        $magang->save();
        
        $message = $data['status'] == 'diterima' ? 'Berhasil menyetujui magang' : 'Berhasil menolak magang';

        return Api::response(
            MagangResource::make($magang),
            $message,
            Response::HTTP_OK
        );
    }

    public function getMagangById(int $id)
    {
        $magang = $this->MagangInterface->find($id);
        return Api::response(
            MagangResource::make($magang),
            'Magang fetched successfully',
            Response::HTTP_OK
        );
    }
}