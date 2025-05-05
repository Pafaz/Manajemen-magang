<?php

namespace App\Interfaces;

use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\GetAllInterface;
use App\Interfaces\Base\UpdateInterface;

interface CabangInterface extends GetAllInterface, CreateInterface, DeleteInterface, UpdateInterface
{
    public function getCabangByPerusahaanId($id);
    public function find(int $id, $perusahaanId);

}