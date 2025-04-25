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
        'nama',
        'id_perusahaan',
        'id_cabang',
        'id_kategori-proyek',
        'created_at',
        'updated_at',
    ];

    public function divisiCabang()
    {
        return $this->hasMany(Divisi_cabang::class, 'divisi_id');
    }
}
