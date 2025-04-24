<?php

namespace App\Interfaces;

use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\GetAllInterface;
use App\Interfaces\Base\UpdateInterface;

interface AdminInterface extends DeleteInterface, FindInterface, GetAllInterface, UpdateInterface
{
    public function getByCabang(int $id_cabang);
    
    public function create(array $data, $role);
}