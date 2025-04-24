<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class PerusahaanDetailResource extends JsonResource
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
            'deskripsi' => $this->deskripsi,
            'provinsi' => $this->provinsi,
            'kota' => $this->kota,
            'alamat' => $this->alamat,
            'kode_pos' => $this->kode_pos,
            'instagram' => $this->instagram,
            'website' => $this->website,
            'user' => new UserResource($this->user),
            'cabang' => CabangResource::collection($this->cabang),
            'foto' => FotoResource::collection($this->foto),
        ];
    }
}
