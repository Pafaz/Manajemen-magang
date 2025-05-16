<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magang extends Model
{
    /** @use HasFactory<\Database\Factories\MagangFactory> */
    use HasFactory;

    protected $table = 'magang';
    public $timestamps = false;

    protected $fillable = [
        'id_peserta',
        'id_mentor',
        'id_lowongan',
        'id_divisi',
        'mulai',
        'selesai',
        'status', //menunggu, diterima, ditolak
    ];
    public function lowongan(){
        return $this->belongsTo(Lowongan::class, 'id_lowongan');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'id_mentor');
    }

    public function foto()
    {
        return $this->hasMany(Foto::class, 'id_referensi')->where('context', 'magang');
    }
}
