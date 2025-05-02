<?php

namespace App\Interfaces;

use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\GetAllInterface;
use App\Interfaces\Base\UpdateInterface;
use App\Models\Foto;
use Illuminate\Database\Eloquent\Collection;

interface FotoInterface extends  CreateInterface, DeleteInterface, UpdateInterface
{
    public function getByTypeandReferenceId(string $type, int $id_referensi): ?Foto;

    public function find( $idReferensi);
}