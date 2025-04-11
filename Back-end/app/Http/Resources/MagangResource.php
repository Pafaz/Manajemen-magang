<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MagangResource extends JsonResource
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
            'id_peserta' => $this->id_peserta,
            'id_mentor' => $this->id_mentor,
            'id_divisi_cabang' => $this->id_divisi_cabang,
            'tipe' => $this->tipe,
            'status' => $this->status,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai
        ];
    }
}
