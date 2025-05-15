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
        'status_kehadiran',
        'jam_masuk',
        'jam_pulang',
        'jam_istirahat',
        'jam_kembali',
    ];
}
