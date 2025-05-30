<?php

namespace App\Http\Resources;

use App\Http\Requests\MagangRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PesertaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->id,
            'nama' => $this->user->nama,
            'telepon' => $this->user->telepon,
            'email' => $this->user->email,
            'jurusan' => $this->jurusan,
            'sekolah' => $this->sekolah,
            'nomor_identitas' => $this->nomor_identitas,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
            'mulai_magang' => $this->magang?->mulai,
            'selesai_magang' => $this->magang?->selesai,
            'perusahaan' => $this->magang?->lowongan->perusahaan->user->nama,
            'divisi' => $this->magang?->lowongan->divisi->nama,
            'cabang' => $this->magang?->lowongan->cabang->nama,
            'foto' => FotoResource::collection($this->foto ?? collect()),
        ];
        if ($this->magang) {
            $response['berkas'] = FotoResource::collection($this->magang->foto);
        }

        return $response;
    }
}
