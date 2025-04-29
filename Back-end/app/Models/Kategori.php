<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    /** @use HasFactory<\Database\Factories\KategoriFactory> */
    use HasFactory;

    protected $table = 'kategori_proyek';

    protected $fillable = [
        'nama',
        'id_perusahaan',
        'created_at',
        'updated_at',
    ];

    public function foto()
    {
        return $this->hasOne(Foto::class, 'id_referensi')->where('type', 'card');
    }
}
