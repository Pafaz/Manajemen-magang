<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    /** @use HasFactory<\Database\Factories\CabangFactory> */
    use HasFactory;

    protected $table = 'cabang';

    public function adminCabang()
    {
        return $this->hasMany(Admin_cabang::class, 'id_cabang', 'id');
    }
    public function divisiCabang()
    {
        return $this->hasMany(Divisi_cabang::class, 'id_cabang', 'id');
    }
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id');
    }
    public function divisi()
    {
        return $this->hasMany(Divisi::class, 'id_cabang', 'id');
    }
}
