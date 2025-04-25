<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    /** @use HasFactory<\Database\Factories\KategoriFactory> */
    use HasFactory;

    protected $table = 'kategori-proyek';

    protected $fillable = [
        'nama',
        'id_perusahaan',
        'created_at',
        'updated_at',
    ];

    public function foto()
    {
        return $this->hasMany(Foto::class, 'id_referensi', 'id');
    }
}
