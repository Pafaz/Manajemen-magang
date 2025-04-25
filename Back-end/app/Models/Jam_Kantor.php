<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jam_Kantor extends Model
{
    /** @use HasFactory<\Database\Factories\JamKantorFactory> */
    use HasFactory;

    protected $table = 'jam_kantor';

    protected $fillable = [
        'id_perusahaan',
        'id_cabang',
        'hari',
        'jenis_sesi',
        'masuk',
        'istirahat',
        'kembali',
        'pulang',
        'created_at',
        'updated_at'
    ];
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }
}
