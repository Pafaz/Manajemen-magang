<?php

namespace App\Interfaces;

use App\Models\User;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\GetAllInterface;

interface UserInterface extends GetAllInterface, CreateInterface, DeleteInterface
{
    public function find(string $email): ? User;
}