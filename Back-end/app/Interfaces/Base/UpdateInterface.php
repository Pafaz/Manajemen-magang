<?php

namespace App\Interfaces\Base;

interface UpdateInterface
{
    public function update(int $id, array $data): bool;
}