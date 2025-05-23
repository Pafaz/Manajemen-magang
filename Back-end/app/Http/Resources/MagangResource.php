<?php

namespace App\Http\Resources;

use App\Models\Foto;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MagangResource extends JsonResource
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
            'user' => PesertaResource::make($this->peserta)
        ];
    }
}
