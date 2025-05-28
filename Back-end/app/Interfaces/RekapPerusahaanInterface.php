<?php

namespace App\Interfaces;

use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\CreateInterface;

interface RekapPerusahaanInterface extends CreateInterface, FindInterface
{
    public function update($id_perusahaan, array $data);
}