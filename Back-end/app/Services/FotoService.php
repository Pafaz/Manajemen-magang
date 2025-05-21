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

            $foto = $this->FotoInterface->getByTypeandReferenceId($type, $idReferensi, $context);
                
            if (!$foto) {
                $foto = $this->FotoInterface->create([
                    'id_referensi' => $idReferensi,
                    'type' => $type,
                    'context' => $context,
                    'path' => $path,
                ]);
            } else {
                // Hapus file lama jika ada
                if (Storage::disk('public')->exists($foto->path)) {
                    Storage::disk('public')->delete($foto->path);
                }

                // Update record yang sudah ada
                $foto = $this->FotoInterface->update($foto->id, [
                    'path' => $path,
                ]);
            }

            DB::commit();
            return $foto;
        } catch (\Exception $e) {
            DB::rollBack();
            // Hapus file yang sudah diupload jika gagal
            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            throw $e;
        }
    }

}
