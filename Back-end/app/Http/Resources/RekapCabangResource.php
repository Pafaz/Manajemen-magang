<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RekapCabangResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'id_cabang' => $this->id_cabang,
            'total_peserta' => $this->total_peserta,
            'total_admin' => $this->total_admin,
            'total_mentor' => $this->total_mentor,
            'total_divisi' => $this->total_divisi,
            'peserta_per_bulan_tahun' => json_decode($this->peserta_per_bulan_tahun),
            'absensi_12_bulan' => json_decode($this->absensi_12_bulan),
            'peserta_per_divisi' => $this->peserta_per_divisi,
            'mentor_per_divisi' => $this->mentor_per_divisi,
        ];
    }
}
