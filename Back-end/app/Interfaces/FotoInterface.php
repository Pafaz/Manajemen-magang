<?php

namespace App\Interfaces;

use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\GetAllInterface;
use App\Interfaces\Base\UpdateInterface;
use App\Models\Foto;

interface FotoInterface extends GetAllInterface, CreateInterface, DeleteInterface, FindInterface, UpdateInterface
{
    public function getByTypeandReferenceId(string $type, int $id_referensi): ?Foto;
}