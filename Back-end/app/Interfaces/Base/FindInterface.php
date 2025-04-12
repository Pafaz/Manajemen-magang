<?php

namespace App\Interfaces\Base;

use Illuminate\Database\Eloquent\Model;

interface FindInterface
{
    public function find(int $id): ?Model;
}