<?php

namespace App\Services;

use App\Helpers\Api;
use App\Models\Izin;
use App\Interfaces\IzinInterface;
use App\Interfaces\KategoriInterface;
use App\Http\Resources\CategoryResource;
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

    public function getCategories($id = null)
    {

        $kategori = $id ? $this->izinInterface->find($id) : $this->izinInterface->getAll();
        if (!$kategori) {
            return Api::response(null, 'Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $data = $id
            ? CategoryResource::make($this->izinInterface->find($id))
            : CategoryResource::collection($this->izinInterface->getAll());

        $message = $id
            ? 'Berhasil mengambil data kategori'
            : 'Berhasil mengambil semua data kategori';

        return Api::response($data, $message);
    }

    public function simpanIzin(array $data, bool $isUpdate = false, $id = null)
    {
        $user = auth('sanctum')->user();

        // dd($pesertaId);
        if (!$user->peserta->id) {
            return Api::response(null, 'Peserta tidak ditemukan.', Response::HTTP_FORBIDDEN);
        }

        if(!$user->peserta->magang){
            return Api::response(null, 'Anda harus magang terlebih dahulu.', Response::HTTP_FORBIDDEN);
        }

        $izin = $isUpdate
            ? $this->izinInterface->update(id: $id, data: [
                'id_peserta' => $user->peserta->id,
                'status' => $data['status'],
                'deskripsi' => $data['deskripsi'],
                'mulai' => $data['mulai'],
                'selesai' => $data['selesai'],
                'status_izin' => $data['status_izin'],
            ])
            : $this->izinInterface->create([
                'id_peserta' => $user->peserta->id,
                'status' => $data['status'],
                'deskripsi' => $data['deskripsi'],
                'mulai' => $data['mulai'],
                'selesai' => $data['selesai'],
                'status_izin' => 'menunggu',
            ]);

        if (!empty($data['bukti'])) {
            $isUpdate
                ? $this->foto->updateFoto($data['bukti'], idReferensi: $izin->id, type: 'bukti', context: 'izin')
                : $this->foto->createFoto($data['bukti'], $izin->id, 'bukti', 'izin');
        }
        $message = $isUpdate
            ? 'Berhasil memperbarui izin'
            : 'Berhasil membuat izin';

        $statusCode = $isUpdate
            ? Response::HTTP_OK
            : Response::HTTP_CREATED;

        return Api::response(
            CategoryResource::make($izin),
            $message,
            $statusCode
        );

    }

    public function deleteCategory(int $id)
    {
        $this->izinInterface->delete($id);
        return Api::response(
            null,
            'Kategori berhasil dihapus',
            Response::HTTP_OK
        );
    }

}
