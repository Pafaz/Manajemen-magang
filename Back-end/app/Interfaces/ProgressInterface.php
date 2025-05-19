<?php

namespace App\Interfaces;

use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\GetAllInterface;
use App\Interfaces\Base\UpdateInterface;

interface ProgressInterface extends GetAllInterface, CreateInterface, DeleteInterface, UpdateInterface, FindInterface
{
    public function findByRevisi(int $id);
}