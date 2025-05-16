<?php

namespace App\Interfaces;

interface RouteInterface
{
    public function createOrUpdate($id_peserta, $id_kategori_proyek, array $data);
    public function findByPesertaAndKategori($id_peserta, $id_kategori_proyek);
    public function markStarted($id_peserta, $id_kategori_proyek);
    public function markFinished($id_peserta, $id_kategori_proyek);
}
