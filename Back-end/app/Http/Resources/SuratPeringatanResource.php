<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuratPeringatanResource extends JsonResource
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
            "keterangan_surat" => $this->keterangan_surat,
            "alasan" => $this->alasan,
            "file_path"=> $this->file_path,
        ];
    }
}
