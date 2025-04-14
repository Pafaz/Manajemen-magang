<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerusahaanResource extends JsonResource
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
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'alamat' => $this->alamat,
            'instagram' => $this->instagram,
            'website' => $this->website,
            'is_premium' => $this->is_premium,
            'cabang_limit' => $this->cabang_limit,
            'admin_limit' => $this->admin_limit,
            'status' => $this->status,
        ];
    }
}
