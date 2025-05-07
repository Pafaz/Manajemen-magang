<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\IzinResource;
use App\Http\Resources\JurnalResource;
use App\Interfaces\JurnalInterface;
use Symfony\Component\HttpFoundation\Response;

class AbsensiService
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

    public function simpanAbsensi(array $data, $isUpdate = false, $id = null)
    {
        // dd($data);
        $user = auth('sanctum')->user();

        if (!$user->peserta || !$user->peserta->id) {
            return Api::response(null, 'Peserta belum melengkapi profil.', Response::HTTP_FORBIDDEN);
        }

        // if (!$user->peserta->id_cabang_aktif) {
        //     return Api::response(null, 'Anda belum terdaftar magang.', Response::HTTP_FORBIDDEN);
        // }
        if(now()->format('H:i:s') < '08:00:00' || now()->format('H:i:s') > '16:00:00'){
            $jam = now()->format('H:i:s');
        } else 

        $jurnal = $isUpdate
            ? $this->jurnalInterface->update($id, $jam)
            : $this->jurnalInterface->create([
                'id_peserta' => $user->peserta->id,
                'tanggal' => date('Y-m-d'),
                'masuk' => now(),
            ]);

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
