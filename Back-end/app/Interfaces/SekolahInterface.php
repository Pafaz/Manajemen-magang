<?php

namespace App\Interfaces;

use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\UpdateInterface;
use App\Interfaces\Base\DivisiInterfaceInBase;

interface SekolahInterface extends DivisiInterfaceInBase, CreateInterface, DeleteInterface, FindInterface, UpdateInterface
{

}
