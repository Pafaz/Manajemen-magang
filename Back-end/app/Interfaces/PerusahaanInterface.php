<?php

namespace App\Interfaces;

use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\UpdateInterface;

interface PerusahaanInterface extends CreateInterface, DeleteInterface, FindInterface, UpdateInterface
{
    public function findByUser($id);
    public function getAll();
}