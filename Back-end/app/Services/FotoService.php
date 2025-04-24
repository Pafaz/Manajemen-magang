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
use Illuminate\Support\Str;

class FotoService
{
    private FotoInterface $FotoInterface;

    public function __construct(FotoInterface $FotoInterface)
    {
        $this->FotoInterface = $FotoInterface;
    }

    public function getByReferenceId($id_referensi){
        return $this->FotoInterface->find($id_referensi);

    }
    public function getByTypeandReferenceId(string $type, $id_referensi)
    {
        $foto = $this->FotoInterface->getByTypeandReferenceId($type, $id_referensi);
        return $foto;
    }

    public function createFoto($file, $idReferensi, $type)
    {
        if (!($file instanceof \Illuminate\Http\UploadedFile)) {
            throw new \InvalidArgumentException('Invalid file upload.');
        }
    
        $uuid = Str::uuid()->toString();
        $ext = $file->getClientOriginalExtension();
        $path = $file->storeAs("{$type}/{$idReferensi}", "{$uuid}.{$ext}", 'public');

        $foto = $this->FotoInterface->create([
            'id_referensi' => $idReferensi,
            'type' => $type,
            'path' => $path,
        ]);
        return $foto;
    }

    public function updateFoto(int $id, array $data)
    {
        if (!isset($data['file']) || !($data['file'] instanceof \Illuminate\Http\UploadedFile)) {
            throw new \InvalidArgumentException('Invalid file upload.');
        }

        DB::beginTransaction();
        try {
            // Store the new file
            $uuid = Str::uuid()->toString();
            $ext = $data['file']->getClientOriginalExtension();
            $path = $data['file']->storeAs("foto/{$data['type']}/{$data['id_referensi']}", "{$uuid}.{$ext}", 'public');

            // Find the existing photo
            $foto = $this->FotoInterface->find($id);
            if (!$foto) {
                return Api::response(
                    null,
                    'Foto not found',
                    Response::HTTP_NOT_FOUND
                );
            }

            // Delete the old file if it exists
            if (Storage::disk('public')->exists($foto->path)) {
                Storage::disk('public')->delete($foto->path);
            }

            // Update the photo record
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
        $this->FotoInterface->delete($foto->id);
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
