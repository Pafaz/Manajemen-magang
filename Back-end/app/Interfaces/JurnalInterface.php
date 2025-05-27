<?php

namespace App\Interfaces;

use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\GetAllInterface;
use App\Interfaces\Base\UpdateInterface;

interface JurnalInterface extends GetAllInterface, CreateInterface, DeleteInterface, FindInterface,UpdateInterface
{
    public function findByPesertaAndTanggal($idPeserta, $tanggal);
    public function countByPerusahaan($id_perusahaan);
    public function getRekapJurnalByPeserta(array $idPeserta);
}