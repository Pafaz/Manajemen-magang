<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi_cabang extends Model
{
    /** @use HasFactory<\Database\Factories\DivisiCabangFactory> */
    use HasFactory;

    protected $table = 'divisi_cabang';
    public $timestamps = false;
    protected $fillable = ['divisi_id', 'cabang_id', 'kuota'];

    public function divisi(){
        return $this->belongsTo(Divisi::class);
    }
    public function cabang(){
        return $this->belongsTo(Cabang::class);
    }
}
