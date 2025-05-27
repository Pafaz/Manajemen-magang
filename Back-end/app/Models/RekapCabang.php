<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapCabang extends Model
{
    protected $fillable = [
        'id_cabang',
        'total_peserta',
        'total_admin',
        'total_mentor',
        'total_divisi',
        'peserta_per_bulan_tahun',
        'rekap_jurnal_peserta',
        'absensi_12_bulan',
        'peserta_per_divisi',
        'mentor_per_divisi',
    ];

    protected $casts = [
        'peserta_per_divisi' => 'array',
        'mentor_per_divisi' => 'array',
    ];
}
