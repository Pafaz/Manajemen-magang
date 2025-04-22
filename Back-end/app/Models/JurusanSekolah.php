<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurusanSekolah extends Model
{
    use HasFactory;

    // Karena ini adalah tabel pivot, kita tidak perlu mendefinisikan primary key
    // Secara default Laravel akan menggunakan composite key yang ada di tabel pivot

    protected $table = 'jurusan_sekolah';

    // Kolom-kolom yang diizinkan untuk diisi (optional)
    protected $fillable = [
        'id_jurusan',
        'id_sekolah',
    ];

    public $timestamps = false; // Jika tabel tidak memiliki kolom timestamps
}
