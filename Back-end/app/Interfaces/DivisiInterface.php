<?php

namespace App\Interfaces;

use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\DivisiInterfaceInBase;
use App\Interfaces\Base\UpdateInterface;

interface DivisiInterface extends DivisiInterfaceInBase, CreateInterface, DeleteInterface, FindInterface, UpdateInterface
{
    //
}
