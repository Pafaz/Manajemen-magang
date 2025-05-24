<?php

namespace App\Interfaces;

use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\GetAllInterface;
use App\Interfaces\Base\UpdateInterface;

interface AbsensiInterface extends GetAllInterface, CreateInterface, DeleteInterface, FindInterface, UpdateInterface
{
    public function findByDate($idPeserta, $tanggal);
    public function countAbsensiByCabang(int $idCabang, int $bulan, int $tahun, string $status);
}