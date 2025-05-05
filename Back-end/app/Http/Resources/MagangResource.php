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
        // dd($this);
        return [
            'id' => $this->id,
            'id_mentor' => $this->id_mentor,
            'status' => $this->status,
            'tanggal_mulai' => $this->mulai,
            'tanggal_selesai' => $this->selesai,
            'peserta' => $this->peserta->user->nama,
            'berkas' => FotoResource::collection($this->foto),
        ];
    }
}
