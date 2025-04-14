<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\PesertaDetailResource;
use App\Http\Resources\PesertaResource;
use App\Interfaces\PesertaInterface;
use Symfony\Component\HttpFoundation\Response;

class PesertaService 
{
    private PesertaInterface $pesertaInterface;
    private FotoService $foto;

    public function __construct(PesertaInterface $pesertaInterface, FotoService $foto)
    {
        $this->foto = $foto;
        $this->pesertaInterface = $pesertaInterface;
    }

    public function getAllPeserta()
    {
        $data = $this->pesertaInterface->getAll();
        return Api::response(
            PesertaResource::collection($data),
            'Peserta Fetched Successfully', 
        );
    }

    public function getPesertaById($id){
        $peserta = $this->pesertaInterface->find($id);
        return Api::response(
            PesertaDetailResource::make($peserta),
            'Peserta Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function createPeserta(array $data)
    {
        $peserta = $this->pesertaInterface->create($data);
        $peserta->user->update([
            'name' => $data['nama'],
            'telepon' => $data['telepon']
        ]);
        $files = [
            'foto' => 'profile',
            'cv' => 'cv',
            'pernyataan_diri' => 'pernyataan_diri',
            'pernyataan_ortu' => 'pernyataan_ortu',
        ];
        foreach ($files as $key => $tipe) {
            if (!empty($data[$key])) {
                $this->foto->createFoto($data[$key], $peserta->id, $tipe);
            }
        }
        
        return Api::response(
            PesertaResource::make($peserta),
            'Peserta Created Successfully',
            Response::HTTP_CREATED
        );
    }

    public function updatePeserta(array $data, $id)
    {
        $peserta = $this->pesertaInterface->update($id, $data);
        return Api::response(
            PesertaResource::make($peserta),
            'Peserta Updated Successfully',
            Response::HTTP_OK
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