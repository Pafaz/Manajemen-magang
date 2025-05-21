<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MentorDetailResource extends JsonResource
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
            'id_divisi' => $this->id_divisi,
            'user' => new UserResource($this->user),
            'divisi' => new DivisiResource($this->divisi),
            'foto' => FotoResource::collection($this->foto),
            'peserta' => $this->magang->map(function ($magang) {
                return [
                    'nama' => $magang->peserta->user->nama,
                    'email' => $magang->peserta->user->email,
                    'sekolah' => $magang->peserta->user->sekolah,
                    'foto' => new FotoResource(
                        $magang->peserta->foto->where('type', 'profile')->first()
                    ),
                ];
            }),
        ];
    }
}
