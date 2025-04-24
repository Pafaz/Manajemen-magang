<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CabangResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'bidang_usaha' => $this->bidang_usaha,
            'provinsi' => $this->provinsi,
            'kota' => $this->kota,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'website' => $this->website,
        ];
    }
}
