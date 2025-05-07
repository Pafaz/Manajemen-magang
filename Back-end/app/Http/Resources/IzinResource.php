<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IzinResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'mulai' => $this->mulai,
            'selesai' => $this->selesai,
            'deskripsi' => $this->deskripsi,
            'jenis' => $this->jenis,
            'status_izin' => $this->status_izin,
            'bukti' => FotoResource::make($this->foto),
            'peserta' => PesertaResource::make($this->peserta),
        ];
    }
}
