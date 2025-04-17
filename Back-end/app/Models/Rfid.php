<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rfid extends Model
{
    /** @use HasFactory<\Database\Factories\RfidFactory> */
    use HasFactory;

    protected $table = 'rfid';

    protected $fillable = [
        'id_peserta_magang',
        'rfid_code',
    ];

    public $timestamps = false;

    public function peserta_magang()
    {
        return $this->belongsTo(Peserta::class);
    }
}
