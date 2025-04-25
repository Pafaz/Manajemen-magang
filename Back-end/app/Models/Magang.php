<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magang extends Model
{
    /** @use HasFactory<\Database\Factories\MagangFactory> */
    use HasFactory;

    protected $table = 'magang';

    protected $fillable = [
        'id_peserta',
        'id_perusahaan',
        'id_mentor',
        'id_cabang',
        'tipe',
        'mulai',
        'selesai',
        'status',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'id_mentor');
    }
    public function divisiCabang()
    {
        return $this->belongsTo(Divisi_cabang::class, 'id_divisi_cabang');
    }
}
