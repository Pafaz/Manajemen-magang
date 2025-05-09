<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    /** @use HasFactory<\Database\Factories\AbsensiFactory> */
    use HasFactory;

    protected $table = 'absensi';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'id_peserta',
        'tanggal',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function magang()
    {
        return $this->belongsTo(Magang::class, 'magang_id');
    }
    public function izin()
    {
        return $this->belongsTo(Izin::class, 'izin_id');
    }
}
