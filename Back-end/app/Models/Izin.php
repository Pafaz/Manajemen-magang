<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    /** @use HasFactory<\Database\Factories\IzinFactory> */
    use HasFactory;
    protected $table = 'izin';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'id_cabang',
        'id_peserta',
        'jenis',
        'deskripsi',
        'mulai',
        'selesai',
        'status_izin'
    ];

    public function foto(){
        return $this->hasOne(Foto::class, 'id_referensi')->where('context', 'izin');
    }
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
