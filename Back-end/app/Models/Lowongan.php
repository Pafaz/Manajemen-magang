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
    protected $fillable = ['id_divisi_cabang', 'id_perusahaan', 'max_kuota'];
}
