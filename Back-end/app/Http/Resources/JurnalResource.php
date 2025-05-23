<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JurnalResource extends JsonResource
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
            'nama' => $this->peserta->user->nama,
            'sekolah' => $this->peserta->sekolah,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'tanggal' => $this->tanggal,
            'created_at' => $this->created_at, 
            'updated_at'=> $this->updated_at,
            'bukti' => FotoResource::make($this->foto), 
        ];
    }
}
