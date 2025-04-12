<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    /** @use HasFactory<\Database\Factories\DivisiFactory> */
    use HasFactory;

    protected $table = 'divisi';

    protected $fillable = [
        'id',
        'id_perusahaan',
        'nama',
    ];

    public function divisiCabang()
    {
        return $this->hasMany(Divisi_cabang::class, 'divisi_id');
    }
}
