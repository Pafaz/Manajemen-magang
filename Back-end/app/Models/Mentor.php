<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    /** @use HasFactory<\Database\Factories\MentorFactory> */
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'mentor';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_user',
        'id_divisi',
        'id_cabang'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function magang()
    {
        return $this->hasMany(Magang::class, 'id_mentor');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi');
    }

    public function foto()
    {
        return $this->hasMany(Foto::class, 'id_referensi', 'id');
    }
}
