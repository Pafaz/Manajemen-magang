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
        'id_cabang',
        'keterangan_surat',
        'alasan',
        'jenis',
        'file_path',
        'created_at',
        'updated_at',
    ];

    // relasi ke peserta magang
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }

    // relasi ke admin cabang
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }
}
