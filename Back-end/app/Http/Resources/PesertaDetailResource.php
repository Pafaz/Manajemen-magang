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
            'mulai_magang' => $this->magang->mulai || null,
            'selesai_magang' => $this->magang->selesai || null,
            'mentor' => $this->magang->mentor->user->nama,
            'divisi' => $this->magang->lowongan->divisi->nama,
            // 'route' => $this->magang->lowongan->divisi->kategori->nama,
            'perusahaan' => $this->magang->lowongan->perusahaan->user->nama,
            'cabang' => CabangResource::make($this->magang->lowongan->cabang),
            'foto' => FotoResource::collection($this->foto?? collect()),
            // 'rfid' => $this->rfid
            // 'jurnal'
            // 'kehadiran'
            // 'status_sp'
        ];
    }
}
