<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapPerusahaan extends Model
{
    protected $table = 'rekap_perusahaan';
    protected $fillable = [
        'id_perusahaan',
        'total_cabang',
        'total_jurnal',
        'peserta'
    ];
}
