<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    /** @use HasFactory<\Database\Factories\PerusahaanFactory> */
    use HasFactory, HasUuids;

    protected $table = 'perusahaan';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
        'id_user',
        'deskripsi',
        'provinsi',
        'kota',
        'alamat',
        'kode_pos',
        'bidang_usaha',
        'website',
        'is_premium',
        'is_active',
        'cabang_limit',
        'admin_limit',
        'nama_penanggung_jawab',
        'nomor_penanggung_jawab',
        'jabatan_penanggung_jawab',
        'email_penanggung_jawab',
        'tanggal_berdiri',
    ];

    public function foto()
    {
        return $this->hasMany(Foto::class, 'id_referensi', 'id');
    }
    public function user()
    {
        return $this->hasMany(User::class, 'id_user', 'id');
    }
    public function cabang()
    {
        return $this->hasMany(Cabang::class, 'id_perusahaan', 'id');
    }

    public function admin_perusahaan()
    {
        return $this->hasMany(Admin_perusahaan::class, 'id_perusahaan', 'id');
    }  
}
