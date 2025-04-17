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
    ];

    public $timestamps = false;

    public function jurusan()
    {
        return $this->belongsToMany(Jurusan::class, 'jurusan_sekolah', 'id_sekolah', 'id_jurusan');
    }
    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'sekolah_id', 'id');
    }
    public function getJurusan()
    {
        return $this->hasMany(Jurusan::class, 'id', 'jurusan_id');
    }
    public function getPeserta()
    {
        return $this->hasMany(Peserta::class, 'sekolah_id', 'id');
    }
}
