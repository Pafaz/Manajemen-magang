<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    /** @use HasFactory<\Database\Factories\ProgressFactory> */
    use HasFactory;

    protected $table = 'progress';
    public $timestamps = false;
    protected $fillable = [
        'id_revisi',
        'deskripsi',
        'status'
    ];

    public function revisi()
    {
        return $this->belongsTo(Revisi::class, 'id_revisi');
    }

}
