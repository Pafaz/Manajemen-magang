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
        'deskripsi',
        'status',
        'presentasi_id',
    ];

    public function presentasi()
    {
        return $this->belongsTo(Presentasi::class);
    }
}
