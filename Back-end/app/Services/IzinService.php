<?php

namespace App\Services;

use App\Helpers\Api;
use App\Models\Izin;
use App\Interfaces\IzinInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\IzinResource;
use App\Interfaces\KategoriInterface;
use App\Http\Resources\CategoryResource;
use App\Interfaces\AbsensiInterface;
use Symfony\Component\HttpFoundation\Response;

class IzinService
{
    private IzinInterface $izinInterface;
    private FotoService $foto;
    private AbsensiInterface $absensiInterface;

    public function __construct(IzinInterface $izinInterface, FotoService $foto, AbsensiInterface $absensiInterface)
    {
        $this->foto = $foto;
        $this->izinInterface = $izinInterface;
        $this->absensiInterface = $absensiInterface;
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

        if (!$user->peserta->id_cabang_aktif) {
            return Api::response(null, 'Anda belum terdaftar magang.', Response::HTTP_FORBIDDEN);
        }

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

    public function approveIzin(array $data, $id)
    {
        if ($data['status_izin'] === 'ditolak') {
            $this->izinInterface->delete($id);
            return Api::response(null, 'Izin ditolak dan dihapus.', Response::HTTP_OK);
        }

        $izin = $this->izinInterface->update($id, [
            'status_izin' => $data['status_izin'],
        ]);
        $this->absensiInterface->create([
            'id_peserta' => $izin->peserta->id,
            'tanggal' => $izin->mulai,
        ])
        return Api::response(
            $izin,
            'Berhasil memperbarui status izin',
            Response::HTTP_OK
        );
    }

    public function approveManyIzin(array $ids, string $status)
    {
        DB::beginTransaction();

        try {
            $results = [];

            foreach ($ids as $id) {
                $izin = $this->izinInterface->find($id);

                if (!$izin) {
                    $results[] = ['id' => $id, 'status' => 'gagal', 'alasan' => 'Data tidak ditemukan'];
                    continue;
                }

                if (!in_array($status, ['diterima', 'ditolak'])) {
                    $results[] = ['id' => $id, 'status' => 'gagal', 'alasan' => 'Status tidak valid'];
                    continue;
                }

                if ($status === 'ditolak') {
                    $this->izinInterface->delete($id);
                    $results[] = ['id' => $id, 'status' => 'ditolak dan dihapus'];
                } else {
                    $this->izinInterface->update($id, ['status_izin' => $status]);
                    $results[] = ['id' => $id, 'status' => 'status diubah menjadi diterima'];
                }
            }

            DB::commit();
            return Api::response($results, 'Batch update status izin selesai', Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return Api::response(null, 'Terjadi kesalahan: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
