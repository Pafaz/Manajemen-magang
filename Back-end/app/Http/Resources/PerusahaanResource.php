<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerusahaanResource extends JsonResource
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
            'id_user' => $this->id_user,
            'nama' => $this->user->name,
            'telepon' => $this->user->telepon,
            'email' => $this->user->email,
            'deskripsi' => $this->deskripsi,
            'alamat' => $this->alamat,
            'provinsi' => $this->provinsi,
            'kota' => $this->kota,
            'kecamatan' => $this->kecamatan,
            'kode_pos' => $this->kode_pos,
            'website' => $this->website,
            'bidang_usaha' => $this->bidang_usaha,
            'tanggal_berdiri' => $this->tanggal_berdiri,
            'nama_penanggung_jawab' => $this->nama_penanggung_jawab,
            'nomor_penanggung_jawab' => $this->nomor_penanggung_jawab,
            'jabatan_penanggung_jawab' => $this->jabatan_penanggung_jawab,
            'email_penanggung_jawab' => $this->email_penanggung_jawab,
        ];
    }
}
