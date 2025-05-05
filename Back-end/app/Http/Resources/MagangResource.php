<?php

namespace App\Http\Resources;

use App\Models\Foto;
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
        // dd($this);
        return [
            'id' => $this->id,
            'id_peserta' => $this->id_peserta,
            'id_mentor' => $this->id_mentor,
            'tipe' => $this->tipe,
            'status' => $this->status,
            'tanggal_mulai' => $this->mulai,
            'tanggal_selesai' => $this->selesai,
            'berkas' => FotoResource::collection($this->foto),
        ];
    }
}
