<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_cabang extends Model
{
    /** @use HasFactory<\Database\Factories\AdminCabangFactory> */
    use HasFactory;

    protected $table = 'admin_cabang';

    protected $fillable = [
        'id',
        'username',
        'password',
        'nama',
        'email',
        'no_telp',
        'alamat',
        'id_divisi_cabang',
        'id_cabang',
    ];
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id');
    }
    public function divisiCabang()
    {
        return $this->belongsTo(Divisi_cabang::class, 'id_divisi_cabang', 'id');
    }
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi_cabang', 'id');
    }
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id');
    }
}
