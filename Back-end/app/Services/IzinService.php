<?php

namespace App\Services;

use App\Helpers\Api;
use App\Models\Izin;
use App\Interfaces\IzinInterface;
use App\Interfaces\KategoriInterface;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\IzinResource;
use Symfony\Component\HttpFoundation\Response;

class IzinService
{
    private IzinInterface $izinInterface;
    private FotoService $foto;

    public function __construct(IzinInterface $izinInterface, FotoService $foto)
    {
        $this->foto = $foto;
        $this->izinInterface = $izinInterface;
    }

    public function getIzin($id = null)
    {

        $kategori = $id ? $this->izinInterface->find($id) : $this->izinInterface->getAll();
        if (!$kategori) {
            return Api::response(null, 'Izin tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $data = $id
            ? IzinResource::make($this->izinInterface->find($id))
            : IzinResource::collection($this->izinInterface->getAll());

        $message = $id
            ? 'Berhasil mengambil data Izin'
            : 'Berhasil mengambil semua data Izin';

        return Api::response($data, $message);
    }

    public function simpanIzinPeserta(array $data)
    {
        $user = auth('sanctum')->user();

        if (!$user->peserta || !$user->peserta->id) {
            return Api::response(null, 'Peserta belum melengkapi profil dahulu.', Response::HTTP_FORBIDDEN);
        }

        // if (!$user->peserta->id_cabang_aktif) {
        //     return Api::response(null, 'Anda belum terdaftar magang.', Response::HTTP_FORBIDDEN);
        // }

        $dataIzin = [
            'id_peserta' => $user->peserta->id,
            'jenis' => $data['jenis'],
            'deskripsi' => $data['deskripsi'],
            'mulai' => $data['mulai'],
            'selesai' => $data['selesai'],
            'status_izin' => 'menunggu',
        ];

        $izin = $this->izinInterface->create($dataIzin);

        if (!empty($data['bukti'])) {
            $this->foto->createFoto($data['bukti'], $izin->id, 'bukti', 'izin');
        }

        return Api::response(
            $izin,
            'Berhasil membuat izin',
            Response::HTTP_OK
        );
    }

    public function updateStatusIzin(array $data, $id)
    {
        if ($data['status_izin'] === 'ditolak') {
            $this->izinInterface->delete($id);
            return Api::response(null, 'Izin ditolak dan dihapus.', Response::HTTP_OK);
        }

        $izin = $this->izinInterface->update($id, [
            'status_izin' => $data['status_izin'],
        ]);

        return Api::response(
            $izin,
            'Berhasil memperbarui status izin',
            Response::HTTP_OK
        );
    }


}
