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
        'kecamatan',
        'alamat',
        'kode_pos',
        'website',
        'is_premium',
        'is_active',
        'cabang_limit',
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
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function cabang()
    {
        return $this->hasMany(Cabang::class, 'id_perusahaan', 'id');
    }

    public function mitra(){
        return $this->hasMany(Sekolah::class, 'id_perusahaan', 'id');
    }  

    public function divisi()
    {
        return $this->hasMany(Divisi::class, 'id_perusahaan', 'id');
    }
}
