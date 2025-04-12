<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    /** @use HasFactory<\Database\Factories\PerusahaanFactory> */
    use HasFactory, HasUuids;

    protected $table = 'perusahaan';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'id_user',
        'nama',
        'deskripsi',
        'alamat',
        'instagran',
        'website',
        'is_premium',
        'cabang_limit',
        'admin_limit',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_perusahaan', 'id');
    }
    public function cabang()
    {
        return $this->hasMany(Cabang::class, 'id_perusahaan', 'id');
    }

}
