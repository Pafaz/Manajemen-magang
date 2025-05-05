<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    /** @use HasFactory<\Database\Factories\FotoFactory> */
    use HasFactory;

    protected $table = 'foto';

    protected $fillable = [
        'type',
        'id_referensi',
        'context',
        'path',
    ];

    public $timestamps = false;
}
