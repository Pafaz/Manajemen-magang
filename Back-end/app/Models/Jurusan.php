<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    /** @use HasFactory<\Database\Factories\JurusanFactory> */
    use HasFactory;

    protected $table = 'jurusan';

    protected $fillable = ['nama'];

    public $timestamps = false;

    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'id_jurusan', 'id');
    }
    public function sekolah()
    {
        return $this->belongsToMany(Sekolah::class, 'jurusan_sekolah', 'id_jurusan', 'id_sekolah');
    }

}
