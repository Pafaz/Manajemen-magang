<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    /** @use HasFactory<\Database\Factories\SuratFactory> */
    use HasFactory;

    protected $table = 'surat';

    protected $fillable = [
        'id_peserta',
        'id_admin_cabang',
        'id_perusahaan',
        'jenis',
        'tanggal',
        'nomor',
        'isi',
        'created_at',
        'updated_at',
    ];

    // relasi ke peserta magang
    public function peserta_magang()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta_magang');
    }

    // relasi ke admin cabang
    public function admin_cabang()
    {
        return $this->belongsTo(User::class, 'id_admin_cabang');
    }
}
