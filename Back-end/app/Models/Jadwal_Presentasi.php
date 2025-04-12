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
        'id',
        'id_mentor',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'kuota',
        'tipe',
        'link_zoom'
    ];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'id_mentor');
    }
    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'id_jadwal_presentasi');
    }
}
