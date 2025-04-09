<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    /** @use HasFactory<\Database\Factories\IzinFactory> */
    use HasFactory;
    protected $table = 'izin';
    protected $fillable = [
        'id',
        'id_peserta',
        'id_admin',
        'id_absensi',
        'tanggal',
        'status',
        'sesi',
        'status_izin',
        'alasan',
        'tanggal_mulai',
        'tanggal_selesai'
    ];

    public function absensi()
    {
        return $this->belongsTo(Absensi::class, 'id_absensi');
    }
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }
}
