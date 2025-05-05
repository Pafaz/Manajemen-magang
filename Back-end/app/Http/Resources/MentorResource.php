<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MentorResource extends JsonResource
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
            'id_divisi' => $this->id_divisi,
            'user' => new UserResource($this->user),
            'divisi' => new DivisiResource($this->divisi),
            'foto' => FotoResource::collection($this->foto),
        ];
    }
}
