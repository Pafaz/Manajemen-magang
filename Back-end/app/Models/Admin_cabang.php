<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_cabang extends Model
{
    /** @use HasFactory<\Database\Factories\AdminCabangFactory> */
    use HasFactory, HasUuids;

    public $timestamps = false;
    protected $table = 'admin_cabang';

    protected $fillable = [
        'id',
        'id_cabang',
        'id_user'
    ];
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id');
    }
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi_cabang', 'id');
    }
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function foto()
    {
        return $this->hasMany(Foto::class, 'id_referensi', 'id');
    }
}
