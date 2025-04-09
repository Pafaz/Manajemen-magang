<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta_Presentasi extends Model
{
    /** @use HasFactory<\Database\Factories\PesertaPresentasiFactory> */
    use HasFactory;

    protected $table = 'peserta_presentasi';
    protected $fillable = [
        'id',
        'id_jadwal_presentasi',
        'id_peserta',
        'status',
    ];
    
    public function jadwal_presentasi()
    {
        return $this->belongsTo(Jadwal_Presentasi::class, 'id_jadwal_presentasi');
    }
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}
