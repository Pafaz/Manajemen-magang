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

    protected $fillable = [
        'id',
        'id_user',
        'id_divisi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function divisiCabang()
    {
        return $this->belongsTo(Divisi_cabang::class, 'id_divisi_cabang');
    }
    public function magang()
    {
        return $this->hasMany(Magang::class, 'id_mentor');
    }
}
