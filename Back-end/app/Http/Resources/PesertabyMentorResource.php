<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PesertabyMentorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id_peserta" => $this->id,
            'nama' => $this->user->nama,
            'email' => $this->user->email,
            'nomor_identitas' => $this->nomor_identitas,
            'sekolah' => $this->sekolah,
            'mulai' => $this->current_route->mulai,
            'selesai' => $this->current_route->selesai,
            'project' => $this->current_route->kategoriProyek->nama,
            'foto' => FotoResource::collection($this->foto),
        ];
    }
}
