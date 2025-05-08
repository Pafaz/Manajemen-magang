<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jam_Kantor extends Model
{
    /** @use HasFactory<\Database\Factories\JamKantorFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $table = 'jam_kantor';

    protected $fillable = [
        'id_cabang',
        'hari',
        'awal_masuk',
        'akhir_masuk',
        'awal_istirahat',
        'akhir_istirahat',
        'awal_kembali',
        'akhir_kembali',
        'awal_pulang',
        'akhir_pulang',
        'status',
    ];
    public function cabang()
    {
        return $this->hasMany(Cabang::class, 'id_cabang');
    }

    public function perusahaan()
    {
        return $this->hasMany(Perusahaan::class,'id_perusahaan');
    }
}
