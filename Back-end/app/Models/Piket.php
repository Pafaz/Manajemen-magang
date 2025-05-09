<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piket extends Model
{
    /** @use HasFactory<\Database\Factories\PiketFactory> */
    use HasFactory;

    protected $table = 'piket';

    protected $fillable = [
        'shift',
        'hari',
        'id_cabang',
    ];

    public function peserta()
    {
        return $this->belongsToMany(Peserta::class, 'piket_peserta');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }
}
