<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapKehadiran extends Model
{
    protected $table = 'rekap_kehadiran';

    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'id_peserta',
        'bulan', 
        'tahun', 
        'total_terlambat', 
        'total_hadir', 
        'total_izin',
        'total_sakit', 
        'total_alpha', 
    ];
}
