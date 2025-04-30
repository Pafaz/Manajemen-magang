<?php

namespace App\Interfaces\Base;

use Illuminate\Database\Eloquent\Collection;

interface GetAllInterface
{
    public function getAll($id ): Collection;
}