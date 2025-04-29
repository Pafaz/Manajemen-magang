<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi_Kategori extends Model
{
    /** @use HasFactory<\Database\Factories\ProyekKategoriFactory> */
    use HasFactory;

    protected $table = 'divisi_kategori';

    protected $fillable = [
        'id_divisi',
        'id_kategori'
    ];
    public $timestamps = false;
}
