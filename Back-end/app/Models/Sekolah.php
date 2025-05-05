<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    /** @use HasFactory<\Database\Factories\SekolahFactory> */
    use HasFactory;

    protected $table = 'sekolah';

    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'jenis_institusi',
        'website',
        'id_cabang'
    ];

    public $timestamps = false;

    public function jurusan()
    {
        return $this->belongsToMany(Jurusan::class, 'jurusan_sekolah', 'id_sekolah', 'id_jurusan');
    }

    public function foto()
    {
        return $this->hasMany(Foto::class, 'id_referensi');
    }

    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'sekolah_id', 'id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id');
    }
}
