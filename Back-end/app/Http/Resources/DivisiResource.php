<?php

namespace App\Http\Resources;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DivisiResource extends JsonResource
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
            'kategori' => CategoryResource::collection($this->kategori),
            'foto' => FotoResource::collection($this->foto),
        ];
    }
}
