<?php

namespace App\Models;

use Illuminate\Http\File;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public static function uploadFoto($filePath, $idReferensi, $type, $context)
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("File does not exist at {$filePath}");
        }

        $uuid = Str::uuid()->toString();
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $filename = "{$uuid}.{$ext}";

        $path = Storage::disk('public')->putFileAs("{$type}/{$idReferensi}", new File($filePath), $filename);

        $foto = self::create([
            'type' => $type,
            'id_referensi' => $idReferensi,
            'context' => $context,
            'path' => $path,
        ]);

        return $foto;
    }
}
