<?php

namespace App\Interfaces;

use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\GetAllInterface;
use App\Interfaces\Base\UpdateInterface;

interface PesertaInterface extends GetAllInterface, CreateInterface, DeleteInterface, FindInterface, UpdateInterface
{
    public function getByCabang($perusahaan);
    public function getJurnalPeserta($idCabang);
    public function getKehadiranPeserta($idCabang);
    public function getDivisiRoute($idCabang);
    public function getDetailRoute($idRoute, $idCabang);
    public function getByProgress($idMentor);
    public function getDetailProgressByMentor($idMentor, $idPeserta);

}