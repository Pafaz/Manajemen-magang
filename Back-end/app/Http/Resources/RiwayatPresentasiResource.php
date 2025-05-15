<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatPresentasiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            'status' => $this->status,
            'projek' => $this->projek,
            'jadwal_presentasi' => JadwalPresentasiResource::make($this->id_jadwal_presentasi),
        ];
    }
}
