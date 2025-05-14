<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $table = 'jurnal';

    protected $fillable = [
        'id_peserta',
        'judul',
        'deskripsi',
        'tanggal',
        'created_at',
        'updated_at'
    ];

    public function peserta(){
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }

    public function foto(){
        return $this->hasOne(Foto::class, 'id_referensi')->where('context', 'jurnal');
    }
}
