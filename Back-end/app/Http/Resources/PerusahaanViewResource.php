<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerusahaanViewResource extends JsonResource
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
            'nama' => $this->user->nama,
            'alamat' => $this->alamat,
            'provinsi' => $this->provinsi,
            'kota' => $this->kota,
            'kecamatan' => $this->kecamatan,
            'rekap' => new RekapPerusahaanResource($this->rekap)
        ];
    }
}
