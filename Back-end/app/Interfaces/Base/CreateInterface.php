<?php

namespace App\Interfaces\Base;

use Illuminate\Database\Eloquent\Model;

interface CreateInterface
{
    public function create(array $data): ?Model;
}