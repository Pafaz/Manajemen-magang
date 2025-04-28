<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    
    public function toArray(Request $request): array
    {
        dd($this);
        return [
            'id' => $this->id,
<<<<<<< HEAD
            'nama' => $this->nama,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'foto' => FotoResource::make($this->foto),
=======
            'nama' => $this->name,
            'deskripsi' => $this->deskripsi,
>>>>>>> parent of eb70cfe (fix: fixing migration)
        ];
    }
}
