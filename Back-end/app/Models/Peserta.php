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
        return $this->hasOne(Magang::class, 'id_peserta');
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_peserta');
    }
    public function izin()
    {
        return $this->hasMany(Izin::class, 'id_peserta');
    }

    public function jurnal()
    {
    return $this->hasMany(Jurnal::class, 'id_peserta');
    }

    public function foto()
    {
        return $this->hasMany(Foto::class, 'id_referensi')->where('context', 'peserta');
    }

    public function piket()
    {
        return $this->belongsToMany(Piket::class, 'piket_peserta', 'peserta_id', 'piket_id');
    }

    public function presentasi()
    {
        return $this->hasMany(Presentasi::class,'id_peserta');
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'id_peserta');
    }

    public function rekapKehadiran()
    {
        return $this->hasMany(RekapKehadiran::class, 'id_peserta');
    }

    public function route()
    {
        return $this->hasOne(Route::class, 'id_peserta');
    }

    public function revisi()
    {
        return $this->hasMany(Revisi::class, 'id_peserta');
    }

    public function magangAktif()
    {
        return $this->hasOne(Magang::class, 'id_peserta')->where('status', 'diterima');
    }

}
