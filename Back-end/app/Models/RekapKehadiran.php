<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapKehadiran extends Model
{
    protected $table = 'rekap_kehadiran';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = [
        'id_peserta',
        'total_terlambat', 
        'total_hadir', 
        'total_izin',
        'total_alpha', 
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta', 'id');
    }
}

