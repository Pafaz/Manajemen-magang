<?php

namespace App\Interfaces;

use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\GetAllInterface;

interface RekapKehadiranInterface extends GetAllInterface, CreateInterface, DeleteInterface, FindInterface
{
    //
}