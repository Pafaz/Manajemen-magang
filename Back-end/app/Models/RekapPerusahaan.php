<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapPerusahaan extends Model
{
    protected $table = 'rekap_perusahaan';

    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = [
        'id_perusahaan', 
        'id_rekap_kehadiran', 
        'total_pendaftar', 
        'total_cabang', 
        'total_peserta',
        'total_jurnal', 
    ];

    public function rekapKehadiran()
    {
        return $this->hasMany(RekapKehadiran::class, 'id_rekap_kehadiran');
    }
}
