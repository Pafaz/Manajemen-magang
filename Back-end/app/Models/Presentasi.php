<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presentasi extends Model
{
    /** @use HasFactory<\Database\Factories\PresentasiFactory> */
    use HasFactory;

    protected $table = 'presentasi';

    protected $fillable = [
        'id_peserta',
        'id_jadwal_presentasi',
        'status',
        'projek',
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal_Presentasi::class, 'id_jadwal_presentasi');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}
