<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'nama' => $this->name,
            'email' => $this->email,
            'telepon' => $this->telepon,
            'id_google' => $this->id_google,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
