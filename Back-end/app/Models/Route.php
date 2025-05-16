<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $table = 'route';
    public $timestamps = false;
    protected $fillable =
    [
        'id_peserta',
        'id_kategori_proyek',
        'mulai',
        'selesai'
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }

    public function kategoriProyek()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori_proyek');
    }

    public function revisi()
    {
        return $this->hasMany(Revisi::class, 'id_route');
    }

    public function presentasi()
    {
        return $this->hasMany(Presentasi::class, 'id_route');
    }
}
