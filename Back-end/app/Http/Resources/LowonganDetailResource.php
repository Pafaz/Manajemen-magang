<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LowonganDetailResource extends JsonResource
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
            'requirement' => $this->requirement,
            'jobdesc' => $this->jobdesc,
            'status' => $this->status,
            'durasi' => $this->durasi,
            'total_pendaftar' => $this->totalPeserta,
            'perusahaan' => PerusahaanDetailResource::make($this->perusahaan),
            'cabang' => CabangResource::make($this->cabang),
            'divisi' => DivisiResource::make($this->divisi)
        ];
    }
}