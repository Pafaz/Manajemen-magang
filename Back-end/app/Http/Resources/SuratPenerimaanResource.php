<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuratPenerimaanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "id_cabang" => $this->id_cabang,
            "jenis" => $this->jenis,
            "file_path"=> $this->file_path,
            "peserta" => PesertaResource::make($this->peserta),
            "magang" => MagangResource::make($this->magang)
        ];
    }
}
