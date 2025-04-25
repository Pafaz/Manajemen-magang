<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            'id_perusahaan' => $this->id_perusahaan,
            'user' => new UserResource($this->user),
            'foto' => FotoResource::collection($this->foto),
        ];
    }
}
