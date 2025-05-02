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
        return [
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'max_kuota' => $this->max_kuota,
            'durasi' => $this->durasi,
            'requirement' => $this->requirement,
            'jobdesc' => $this->jobdesc,
            'perusahaan' => new PerusahaanResource($this->perusahaan),
            'divisi' => new DivisiResource($this->divisi)
        ];
    }
}