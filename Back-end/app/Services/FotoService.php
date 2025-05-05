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

    public function createFoto($file, $idReferensi, $type, $context)
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
            'context' => $context,
            'path' => $path,
        ]);
        return $foto;
    }

    public function updateFoto($file, $idReferensi, $type, $context)
    {
        if (!($file instanceof \Illuminate\Http\UploadedFile)) {
            throw new \InvalidArgumentException('Invalid file upload.');
        }

        DB::beginTransaction();

        try {
            $uuid = Str::uuid()->toString();
            $ext = $file->getClientOriginalExtension();
            $path = $file->storeAs("{$type}/{$idReferensi}", "{$uuid}.{$ext}", 'public');

            $foto = $this->FotoInterface->getByTypeandReferenceId($type, $idReferensi);
            if (!$foto) {
                return throw new \InvalidArgumentException('Foto not found.');
            }
                
            if (!$foto) {
                $this->FotoInterface->create([
                    'id_referensi' => $idReferensi,
                    'type' => $type,
                    'context' => $context,
                    'path' => $path,
                ]);
            } else {
                if (Storage::disk('public')->exists($foto->path)) {
                    Storage::disk('public')->delete($foto->path);
                }

                $this->FotoInterface->update($foto->id, [
                    'path' => $path,
                ]);
            }

            $updated = $this->FotoInterface->update($foto->id, [
                'path' => $path,
            ]);

            DB::commit();

            return $updated;
        } catch (\Exception $e) {
            DB::rollBack();
            return Api::response(null, 'Failed to update foto: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
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
