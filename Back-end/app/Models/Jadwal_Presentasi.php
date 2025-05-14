<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal_Presentasi extends Model
{
    /** @use HasFactory<\Database\Factories\JadwalPresentasiFactory> */
    use HasFactory;

    protected $table = 'jadwal_presentasi';

    protected $fillable = [
        'id_mentor',
        'judul',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'kuota',
        'tipe',
        'link_zoom',
        'lokasi',
    ];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'id_mentor');
    }
    public function presentasi()
    {
        return $this->hasMany(Presentasi::class,'id_jadwal_presentasi');
    }
}
