<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    /** @use HasFactory<\Database\Factories\NotifikasiFactory> */
    use HasFactory;

    protected $table = 'notifikasi';
    protected $fillable = [
        'id',
        'id_user',
        'pesan',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
