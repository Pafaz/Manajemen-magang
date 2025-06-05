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
        // dd($this->route);
        return [
            "id_peserta" => $this->id,
            'nama' => $this->user->nama,
            'email' => $this->user->email,
            'nomor_identitas' => $this->nomor_identitas,
            'sekolah' => $this->sekolah,
            'route' => $this->route,
            'foto' => FotoResource::collection($this->foto),
        ];
    }
}
