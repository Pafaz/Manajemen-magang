<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouteDetailPesertaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this);
        return [
            'nama' => $this->user->nama,
            'divisi' => $this->magang->divisi->nama,
            'route' => $this->route,
            'revisi' => $this->revisi,
            'mentor' => MentorResource::make($this->magang->mentor)
        ];
    }
}
