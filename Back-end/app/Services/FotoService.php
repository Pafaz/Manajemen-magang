<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\FotoResource;
use App\Interfaces\FotoInterface;
use Illuminate\Support\Facades\DB;
use App\Interfaces\JurusanInterface;
use App\Http\Resources\JurusanResource;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class FotoService
{
    private FotoInterface $FotoInterface;

    public function __construct(FotoInterface $FotoInterface)
    {
        $this->FotoInterface = $FotoInterface;
    }

    public function getByTypeandReferenceId(string $type, int $id_referensi)
    {
        $foto = $this->FotoInterface->getByTypeandReferenceId($type, $id_referensi);
        if ($foto) {
            return Api::response(
                new FotoResource($foto),
                'Data found',
                Response::HTTP_OK
            );
        } else {
            return Api::response(
                null,
                'Data not found',
                Response::HTTP_NOT_FOUND
            );
        }
    }
    public function createFoto(array $data)
    {
        DB::beginTransaction();
        try {
            $path = $data['file']->store('foto/' . $data['type'] . '/' . $data['id_referensi'], 'public');

            $jurusan = $this->FotoInterface->create([
                'id_referensi' => $data['id_referensi'],
                'type' => $data['type'],
                'path' => $path,
            ]);
            DB::commit();
            return Api::response(
                JurusanResource::make($jurusan),
                'Foto Uploaded successfully',
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return Api::response(
                null,
                'Failed to upload foto: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }


    public function updateFoto(int $id, array $data)
    {
        DB::beginTransaction();
        try {
            $path = $data['file']->store('foto/' . $data['type'] . '/' . $data['id_referensi'], 'public');

            $foto = $this->FotoInterface->find($id);
            if (!$foto) {
                return Api::response(
                    null,
                    'Foto not found',
                    Response::HTTP_NOT_FOUND
                );
            }

            // Hapus file lama
            if (Storage::disk('public')->exists($foto->path)) {
                Storage::disk('public')->delete($foto->path);
            }

            // Update foto
            $foto = $this->FotoInterface->update($id, [
                'id_referensi' => $data['id_referensi'],
                'type' => $data['type'],
                'path' => $path,
            ]);

            DB::commit();
            return Api::response(
                null,
                'Foto updated successfully',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return Api::response(
                null,
                'Failed to update foto: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }


    public function deleteFoto(int $id)
    {
        $foto = $this->FotoInterface->find($id);
        $this->FotoInterface->delete($id);
        // Hapus file dari storage
        if (Storage::disk('public')->exists($foto->path)) {
            Storage::disk('public')->delete($foto->path);
        }
        return Api::response(
            null,
            'Foto deleted successfully',
            Response::HTTP_OK
        );
    }
}
