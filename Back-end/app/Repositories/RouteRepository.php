<?php

namespace App\Repositories;

use App\Models\Route;
use App\Interfaces\RouteInterface;

class RouteRepository implements RouteInterface
{
    public function createOrUpdate($id_peserta, $id_kategori_proyek, array $data)
    {
        return Route::updateOrCreate(
            ['id_peserta' => $id_peserta, 'id_kategori_proyek' => $id_kategori_proyek],
            $data
        );
    }

    public function findByPesertaAndKategori($id_peserta, $id_kategori_proyek)
    {
        return Route::where('id_peserta', $id_peserta)
            ->where('id_kategori_proyek', $id_kategori_proyek)
            ->first();
    }

    public function markStarted($id_peserta, $id_kategori_proyek)
    {
        return $this->createOrUpdate($id_peserta, $id_kategori_proyek, [
            'mulai' => now()
        ]);
    }

    public function markFinished($id_peserta, $id_kategori_proyek)
    {
        return $this->createOrUpdate($id_peserta, $id_kategori_proyek, [
            'selesai' => now()
        ]);
    }
}
