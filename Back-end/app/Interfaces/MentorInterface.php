<?php

namespace App\Interfaces;

use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\GetAllInterface;
use App\Interfaces\Base\UpdateInterface;

interface MentorInterface extends GetAllInterface, CreateInterface, DeleteInterface, FindInterface, UpdateInterface
{
        public function findByIdCabang($id_mentor, $id_cabang);
        public function getMentorPerDivisi($id_cabang);
}