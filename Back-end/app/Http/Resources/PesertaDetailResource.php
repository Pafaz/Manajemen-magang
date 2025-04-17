<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PesertaDetailResource extends JsonResource
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
            'jurusan' => $this->jurusan->nama,
            'sekolah' => $this->sekolah->nama,
            'nomor_identitas' => $this->nomor_identitas,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'kelas' => $this->kelas,
            'alamat' => $this->alamat,
            'user' => new UserResource($this->user),
            'magang' => new MagangResource($this->magang),
        ];
    }
}
