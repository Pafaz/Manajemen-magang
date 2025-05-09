<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CabangResource extends JsonResource
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
            'nama' => $this->nama,
            'bidang_usaha' => $this->bidang_usaha,
            'provinsi' => $this->provinsi,
            'kota' => $this->kota,
            'created_at' => $this->created_at,
            'foto' => FotoResource::collection($this->foto),
        ];
    }
}