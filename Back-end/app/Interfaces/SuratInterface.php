<?php

namespace App\Interfaces;

use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\GetAllInterface;
use App\Models\Surat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface SuratInterface extends GetAllInterface, CreateInterface, DeleteInterface, FindInterface
{
    public function findByPeserta($id_peserta);

    public function getAllByCabang(int $id_cabang, ?string $jenis = null, bool $withPeserta = true): Collection;
    

    public function getAllByPeserta(int $id_peserta, ?string $jenis = null): Collection;
    
    public function getStatsByCabang(int $id_cabang): array;
    
    public function query(): Builder;
}