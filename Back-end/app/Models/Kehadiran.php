<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $table = 'kehadiran';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'id_peserta',
        'tanggal',
        'metode',
        'jam_masuk',
        'jam_pulang',
        'jam_istirahat',
        'jam_kembali',
    ];
}
