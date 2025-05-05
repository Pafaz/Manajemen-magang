<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class PerusahaanDetailResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->foto, $this->user, $this->perusahaan);
        return [
            'perusahaan' => PerusahaanResource::make($this),
            'foto' => FotoResource::collection($this->foto),
        ];
    }
}
