<?php

namespace App\Interfaces;

use App\Models\User;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\GetAllInterface;
use App\Interfaces\Base\UpdateInterface;

interface UserInterface extends GetAllInterface, CreateInterface, DeleteInterface
{
    public function find(string $email): ? User;

    public function findId(string $id): ? User;
    
    public function update(string $id, array $data): User;

    public function firstOrCreateByEmail(array $attributes, array $values): User;

    public function getAdminByCabang(int $id);
}