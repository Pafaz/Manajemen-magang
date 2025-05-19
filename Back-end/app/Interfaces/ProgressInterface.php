<?php

namespace App\Interfaces;

use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\UpdateInterface;

interface ProgressInterface extends CreateInterface, UpdateInterface, FindInterface
{
    public function findByRevisi(int $id);
}