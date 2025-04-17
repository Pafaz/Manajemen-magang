<?php

namespace App\Interfaces;

use App\Models\Jurusan;
use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\GetAllInterface;
use App\Interfaces\Base\UpdateInterface;

interface JurusanInterface extends GetAllInterface, CreateInterface, DeleteInterface, FindInterface, UpdateInterface
{
    public function firstOrCreate(array $attributes): Jurusan;

}