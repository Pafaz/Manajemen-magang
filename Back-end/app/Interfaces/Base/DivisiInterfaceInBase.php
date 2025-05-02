<?php

namespace App\Interfaces\Base;

use Illuminate\Database\Eloquent\Collection;

interface DivisiInterfaceInBase
{
    public function getAll($id): Collection;
}
