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
    public function findByPesertaAndCabang($id_peserta, $id_cabang);
    public function updateByPesertaAndCabang($id_peserta, $id_cabang, array $data);
    public function countPendaftar($lowonganId);
    public function countPeserta($id);
    public function countPesertaPerBulanDanTahun($id);
    public function getMagangPerDivisi($id_cabang);
    public function countPesertaByPerusahaan($id);
}