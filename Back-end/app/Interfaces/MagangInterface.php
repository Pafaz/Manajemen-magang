<?php

namespace App\Interfaces;

use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\GetAllInterface;

interface MagangInterface extends CreateInterface, DeleteInterface, FindInterface
{
    public function alreadyApply($idPeserta, $idLowongan);
    public function getAll($id);
    public function countPendaftar($lowonganId);
}