<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\PesertaDetailResource;
use App\Http\Resources\PesertaResource;
use App\Interfaces\MagangInterface;
use App\Interfaces\PesertaInterface;
use Symfony\Component\HttpFoundation\Response;

class PesertaService 
{
    private PesertaInterface $pesertaInterface;
    private MagangInterface $magangInterface;
    private FotoService $foto;

    public function __construct(PesertaInterface $pesertaInterface, FotoService $foto, MagangInterface $magangInterface)
    {
        $this->foto = $foto;
        $this->pesertaInterface = $pesertaInterface;
        $this->magangInterface = $magangInterface;
    }

    public function getPeserta($id, $isUpdate = false)
    {
        $idcabang = auth('sanctum')->user()->id_cabang_aktif;
        $data = $isUpdate
            ? $this->pesertaInterface->find($id)
            : $this->pesertaInterface->getAll($idcabang);
            
        return Api::response(
            PesertaResource::collection($data),
            'Berhasil mengambil data peserta', 
        );
    }

    public function getPesertaByCabang($cabang){
        $data = $this->pesertaInterface->find($cabang);
        return Api::response(
            PesertaResource::collection($data),
            'Peserta Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function getPesertaByPerusahaan($perusahaan){
        $data = $this->pesertaInterface->getByPerusahaan($perusahaan);
        return Api::response(
            PesertaResource::collection($data),
            'Peserta Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function simpanProfilPeserta(array $data, bool $isUpdate = false, $id = null)
    {
        if ($isUpdate) {
            $peserta = $this->pesertaInterface->update($id, $data);
            $peserta->user->update([
                'nama' => $data['nama'],
                'telepon' => $data['telepon']
            ]);
            
            $statusCode = Response::HTTP_OK;
            $message = 'Peserta berhasil memperbarui profil';
        } else {
            $data['id_user'] = auth('sanctum')->user()->id;
            $peserta = $this->pesertaInterface->create($data);
            $peserta->user->update([
                'nama' => $data['nama'],
                'telepon' => $data['telepon']
            ]);
            $statusCode = Response::HTTP_CREATED;
            $message = 'Peserta berhasil melengkapi profil';
        }

        $files = [
            'foto_profil' => 'foto_profile',
            'cv' => 'cv',
            'pernyataan_diri' => 'pernyataan_diri',
            'pernyataan_ortu' => 'pernyataan_ortu',
        ];

        foreach ($files as $key => $tipe) {
            if (!empty($data[$key])) {
                if ($isUpdate) {
                    $this->foto->updateFoto($data[$key], $peserta->id, $tipe);
                } else {
                    $this->foto->createFoto($data[$key], $peserta->id, $tipe);
                }
            }
        }

        return Api::response(
            PesertaResource::make($peserta),
            $message,
            $statusCode
        );
    }

    public function deletePeserta( $id)
    {
        $this->pesertaInterface->delete($id);
        return Api::response(
            null,
            'Peserta Deleted Successfully',
            Response::HTTP_OK
        );
    }

}