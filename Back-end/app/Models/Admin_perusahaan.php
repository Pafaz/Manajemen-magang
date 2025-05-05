<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_perusahaan extends Model
{
    use HasFactory, HasUuids;
    public $timestamps = false;
    protected $table = 'admin_perusahaan';

    protected $fillable = [
        'id',
        'id_perusahaan',
        'id_user'
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
