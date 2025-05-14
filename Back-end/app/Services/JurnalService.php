<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\JurnalResource;
use App\Interfaces\JurnalInterface;
use Symfony\Component\HttpFoundation\Response;

class JurnalService
{
    private FotoService $foto;
    private JurnalInterface $jurnalInterface;
    public function __construct(JurnalInterface $jurnalInterface, FotoService $foto)
    {
        $this->foto = $foto;
        $this->jurnalInterface = $jurnalInterface;
    }

    public function getJurnal($id = null)
    {

        $jurnal = $id ? $this->jurnalInterface->find($id) : $this->jurnalInterface->getAll();
        if (!$jurnal) {
            return Api::response(null, 'Jurnal tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $data = $id
            ? JurnalResource::make($this->jurnalInterface->find($id))
            : JurnalResource::collection($this->jurnalInterface->getAll());

        $message = $id
            ? 'Berhasil mengambil data jurnal'
            : 'Berhasil mengambil semua data jurnal';

        return Api::response($data, $message);
    }
    public function simpanJurnal(array $data, $isUpdate = false, $id = null)
    {
        // dd($data);
        $user = auth('sanctum')->user();

        if (!$user->peserta || !$user->peserta->id) {
            return Api::response(null, 'Peserta belum melengkapi profil.', Response::HTTP_FORBIDDEN);
        }

        if (!$user->id_cabang_aktif) {
            return Api::response(null, 'Anda belum terdaftar magang.', Response::HTTP_FORBIDDEN);
        }

        $dataJurnal = [
            'id_peserta' => $user->peserta->id,
            'deskripsi' => $data['deskripsi'],
            'judul' => $data['judul'],
        ];

        $jurnal = $isUpdate
            ? $this->jurnalInterface->update($id, $dataJurnal)
            : $this->jurnalInterface->create($dataJurnal);

        if (!empty($data['bukti'])) {
            $isUpdate 
            ? $this->foto->updateFoto($data['bukti'], $jurnal->id, 'bukti', 'jurnal')
            : $this->foto->createFoto($data['bukti'], $jurnal->id, 'bukti', 'jurnal');
        }

        return Api::response(
            JurnalResource::make($jurnal),
            $isUpdate ? 'Berhasil memperbarui jurnal' : 'Berhasil membuat jurnal',
            Response::HTTP_OK
        );
    }

}
