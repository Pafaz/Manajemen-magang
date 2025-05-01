<?php

namespace App\Repositories;

use App\Models\Cabang;
use Illuminate\Support\Str;
use App\Models\Admin_cabang;
use App\Interfaces\AdminInterface;
use App\Models\Admin_perusahaan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AdminRepository implements AdminInterface
{
    public function getAll($id): Collection
    {
        return Admin_cabang::all();
    }

    public function getByCabang($id_cabang)
    {
        return Admin_cabang::where('id_cabang', $id_cabang);
    }

    public function find($id): ?Admin_cabang
    {
        return Admin_cabang::findOrFail($id);
    }

    public function findByUser($id): ?Admin_cabang
    {
        return Admin_cabang::where('id_cabang', $id)->first();
    }

    public function create(array $data): ?Admin_cabang
    {
        return Admin_cabang::create($data);
    }

    public function update($id, array $data): Admin_cabang
    {
        $admin_cabang = Admin_cabang::findOrFail($id);
        $admin_cabang->update($data);
        return $admin_cabang;
    }

    public function delete($id): void
    {
        Admin_cabang::findOrFail($id)->delete();
    }
}