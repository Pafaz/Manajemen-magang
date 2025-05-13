<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LowonganResource extends JsonResource
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
            'total_pendaftar' => $this->totalPeserta,
            'perusahaan' => new PerusahaanDetailResource($this->perusahaan),
            'cabang' => new CabangResource($this->cabang),
            'divisi' => new DivisiResource($this->divisi)
        ];
    }
}