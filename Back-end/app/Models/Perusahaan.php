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
        'nama',
        'deskripsi',
        'provinsi',
        'kota',
        'kecamatan',
        'desa',
        'alamat',
        'kode_pos',
        'telepon',
        'instagram',
        'website',
        'is_premium',
        'is_active',
        'cabang_limit',
        'admin_limit',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function cabang()
    {
        return $this->hasMany(Cabang::class, 'id_perusahaan', 'id');
    }

}
