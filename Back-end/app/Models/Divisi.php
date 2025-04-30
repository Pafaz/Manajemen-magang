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

    public function kategori()
    {
        return $this->belongsToMany(Kategori::class, 'divisi_kategori', 'id_divisi', 'id_kategori');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id');
    }

    public function foto()
    {
        return $this->hasMany(Foto::class, 'id_referensi');
    }
}
