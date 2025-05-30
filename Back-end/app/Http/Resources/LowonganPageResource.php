<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LowonganPageResource extends JsonResource
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
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'max_kuota' => $this->max_kuota,
            'status' => $this->status,
            'total_pendaftar' => $this->totalPeserta,
            'perusahaan'=> $this->perusahaan->user->nama,
            'provinsi' => $this->perusahaan->provinsi,
            'kota' => $this->perusahaan->kota,
            'divisi' => $this->divisi->nama,
            'foto' => FotoResource::collection($this->perusahaan->foto),
        ];
    }
}