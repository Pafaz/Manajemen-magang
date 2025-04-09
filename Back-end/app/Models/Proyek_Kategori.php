<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek_Kategori extends Model
{
    /** @use HasFactory<\Database\Factories\ProyekKategoriFactory> */
    use HasFactory;

    protected $table = 'proyek_kategori';

    protected $fillable = [
        'proyek_id',
        'kategori_id'
    ];
    public $timestamps = false;
}
