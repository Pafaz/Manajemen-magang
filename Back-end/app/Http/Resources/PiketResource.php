<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PiketResource extends JsonResource
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
            "hari"=> $this->hari,
            "shift"=> $this->shift,
            "peserta" => PesertaPiketResource::collection($this->whenLoaded("peserta")),
        ];
    }
}
