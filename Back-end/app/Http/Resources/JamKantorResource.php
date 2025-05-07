<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JamKantorResource extends JsonResource
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
            "hari" => $this->hari,
            "awal_masuk" => $this->awal_masuk,
            "akhir_masuk" => $this->akhir_masuk,
            "awal_istirahat" => $this->awal_istirahat,
            "akhir_istirahat" => $this->akhir_istirahat,
            "awal_kembali" => $this->awal_kembali,
            "akhir_kembali" => $this->akhir_kembali,
            "awal_pulang" => $this->awal_pulang,
            "akhir_pulang" => $this->akhir_pulang
        ];
    }
}
