<?php

namespace App\Interfaces;

use App\Models\User;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\GetAllInterface;
use App\Interfaces\Base\UpdateInterface;

interface UserInterface extends GetAllInterface, CreateInterface, DeleteInterface, UpdateInterface
{
    public function find(string $email): ? User;
}