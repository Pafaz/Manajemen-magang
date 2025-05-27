<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MitraDetailResource extends JsonResource
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
            'total_peserta' => $this->total_peserta,
            'telepon' => $this->user->telepon,
            'email' => $this->user->email,
            'deskripsi' => $this->deskripsi,
            'alamat' => $this->alamat,
            'provinsi' => $this->provinsi,
            'kota' => $this->kota,
            'kecamatan' => $this->kecamatan,
            'foto' => FotoResource::collection($this->foto),
            'mitra' => SchoolResource::collection($this->mitra),
            'cabang' => CabangResource::collection($this->cabang),
        ];
    }
}
