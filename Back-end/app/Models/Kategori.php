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
        'created_at',
        'updated_at',
    ];

    public function divisi()
    {
        return $this->belongsToMany(Divisi::class, 'divisi_kategori', 'id_kategori', 'id_divisi');
    }

}
