<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    /** @use HasFactory<\Database\Factories\LowonganFactory> */
    use HasFactory;

    protected $table = 'lowongan';

    protected $guarded = ['id'];
    protected $fillable = [
        'id_cabang', 
        'id_perusahaan',
        'id_divisi',
        'tanggal_mulai',
        'tanggal_selesai',
        'max_kuota',
        'deskripsi',
        'status',
        'email_hrd',
        'created_at',
        'updated_ay'
    ];
}
