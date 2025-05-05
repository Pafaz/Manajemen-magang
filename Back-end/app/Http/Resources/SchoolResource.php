<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this);
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'jenis_institusi' => $this->jenis_institusi,
            'foto' => FotoResource::collection($this->foto),
            'jurusan' => JurusanResource::collection($this->jurusan),
        ];
    }
}
