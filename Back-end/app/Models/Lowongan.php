<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    /** @use HasFactory<\Database\Factories\LowonganFactory> */
    use HasFactory;

    protected $table = 'lowongan';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = [
        'id_cabang',
        'id_perusahaan',
        'id_divisi',
        'tanggal_mulai',
        'tanggal_selesai',
        'max_kuota',
        'requirement',
        'durasi',
        'jobdesc',
        'status',
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi');
    }
}