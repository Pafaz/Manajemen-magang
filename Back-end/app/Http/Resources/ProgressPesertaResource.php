<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgressPesertaResource extends JsonResource
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
            'nama' => $this->user->nama,
            'email' => $this->user->email,
            'nomor_identitas' => $this->nomor_identitas,
            'sekolah' => $this->sekolah,
            'perusahaan' => $this->magang->lowongan->perusahaan->user->nama,
            'cabang' => $this->magang->lowongan->cabang->nama,
            'mentor' => $this->magang->mentor->user->nama,
            'mulai_magang' => $this->magang->mulai,
            'selesai_magang' => $this->magang->selesai,
            'divisi' => $this->magang->divisi->nama,
            'foto' => FotoResource::collection($this->foto),
            'progress' => $this->route,
            'revisi' => $this->revisi
        ];
    }
}
