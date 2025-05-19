<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PesertaDivisiRouteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nama' => $this->user->nama,
            'perusahaan' => $this->magang->lowongan->perusahaan->user->nama,
            'divisi' => $this->magang->divisi->nama,
            'route' => $this->route,
            'kategori' => CategoryResource::collection($this->magang->divisi->kategori),
            'foto' => FotoResource::collection($this->foto)
        ];
    }
}
