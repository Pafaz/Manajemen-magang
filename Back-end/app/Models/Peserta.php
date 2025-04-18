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
        'id_jurusan',
        'id_sekolah',
        'nomor_identitas',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'kelas',
        'alamat',
    ];
    // public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function magang()
    {
        return $this->belongsTo(Magang::class, 'id_magang');
    }
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah');
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_peserta');
    }
    public function izin()
    {
        return $this->hasMany(Izin::class, 'id_peserta');
    }
}
