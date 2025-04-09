<?php

namespace App\Interfaces\Base;

use Illuminate\Database\Eloquent\Model;

interface UpdateInterface
{
    public function update(int $id, array $data): Model;
}