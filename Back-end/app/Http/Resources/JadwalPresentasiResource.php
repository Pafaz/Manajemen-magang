<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JadwalPresentasiResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tanggal'=> $this->tanggal,
            'waktu_mulai' => $this->waktu_mulai,
            'waktu_selesai' => $this->waktu_selesai,
            'tipe' => $this->tipe,
            'status' => $this->status,
            'link_zoom' => $this->link_zoom ?? null,
            'lokasi' => $this->lokasi ?? null,
            // 'lokasi_atau_zoom' => $this->tipe == 'offline' ? $this->link_zoom : $this->lokasi,
            // 'mentor' => MentorResource::make($this->mentor)->load('user', 'foto'),
        ];
    }
}
