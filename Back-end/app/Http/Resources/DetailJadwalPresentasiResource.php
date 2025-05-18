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
            'id'=> $this->id,
            'tanggal' => $this->tanggal,
            'tipe' => $this->tipe,
            'status' => $this->status,
            'waktu_mulai' => $this->waktu_mulai,
            'waktu_selesai' => $this->waktu_selesai,
            'link_zoom' => $this->link_zoom ?? null,
            'lokasi' => $this->lokasi ?? null,
            'Peserta' => PresentasiPesertaResource::collection($this->presentasi),
        ];
    }
}
