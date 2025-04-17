<?php

namespace App\Interfaces\Base;

interface DeleteInterface
{
    public function delete(int $id): void;
}