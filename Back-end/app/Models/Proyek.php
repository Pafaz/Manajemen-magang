<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    /** @use HasFactory<\Database\Factories\ProjekFactory> */
    use HasFactory;

    protected $table = 'proyek';

    protected $fillable = [
        'id_peserta',
        'id_divisi_cabang',
        'nama',
        'deskripsi',
        'deadline',
        'status',
    ];
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
    public function divisi_cabang()
    {
        return $this->belongsTo(Divisi_cabang::class, 'id_divisi_cabang');
    }
}

