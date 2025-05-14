<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailJadwalPresentasiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'judul' => $this->judul,
            'tanggal' => $this->tanggal,
            'waktu_mulai' => $this->waktu_mulai,
            'waktu_selesai' => $this->waktu_selesai,
            'link_zoom' => $this->link_zoom ?? null,
            'lokasi' => $this->lokasi ?? null,
            'peserta' => PesertaResource::collection($this->whenLoaded('id_peserta')),
        ];
    }
}
