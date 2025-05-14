<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PesertaJurnalResource extends JsonResource
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
            'sekolah' => $this->sekolah,
            'profil' => FotoResource::collection($this->foto),
            'jurnal' => JurnalResource::collection($this->jurnal)
        ];
    }
}
