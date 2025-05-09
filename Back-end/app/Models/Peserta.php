<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    /** @use HasFactory<\Database\Factories\PesertaFactory> */
    use HasFactory, HasUuids;

    protected $table = 'peserta';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id_user',
        'jurusan',
        'sekolah',
        'nomor_identitas',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
    ];

    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function magang()
    {
        return $this->belongsTo(Magang::class, 'id_magang');
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_peserta');
    }
    public function izin()
    {
        return $this->hasMany(Izin::class, 'id_peserta');
    }

    public function foto()
    {
        return $this->hasMany(Foto::class, 'id_referensi')->where('context', 'peserta');
    }

    public function pikets()
    {
        return $this->belongsToMany(Piket::class, 'piket_peserta');
    }
}
