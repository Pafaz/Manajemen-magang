<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerusahaanResource extends JsonResource
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
            'deskripsi' => $this->deskripsi,
            'provinsi' => $this->provinsi,
            'kota' => $this->kota,
            'alamat' => $this->alamat,
            'kode_pos' => $this->kode_pos,
            'instagram' => $this->instagram,
            'website' => $this->website,
            'user' => new UserResource($this->user),
        ];
    }
}
