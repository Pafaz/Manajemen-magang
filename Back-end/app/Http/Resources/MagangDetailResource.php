<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MagangDetailResource extends JsonResource
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
            'mulai' => $this->mulai,
            'selesai' => $this->selesai,
            'status' => $this->status,
            'user' => PesertaResource::make($this->peserta),
            'berkas' => FotoResource::collection($this->foto),
        ];
    }
}
