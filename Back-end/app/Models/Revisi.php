<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revisi extends Model
{
    /** @use HasFactory<\Database\Factories\RevisiFactory> */
    use HasFactory;

    protected $table = 'revisi';

    protected $fillable = [
        'id_peserta',
        'id_route',
        'created_at',
        'updated_at'
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }

    public function progress()
    {
        return $this->hasMany(Progress::class, 'id_revisi');
    }
}
