<?php

namespace App\Http\Resources;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DivisiCabangResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
        ];
    }
}
