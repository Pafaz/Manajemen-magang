<?php

namespace App\Repositories;

use App\Interfaces\AdminInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Admin_cabang;

class AdminRepository implements AdminInterface
{
    public function getAll(): Collection
    {
        return Admin_cabang::all();
    }

    public function getByCabang(int $id_cabang)
    {
        return Admin_cabang::where('id_cabang', $id_cabang)->first();
    }

    public function find(int $id): ? Admin_cabang
    {
        return Admin_cabang::findOrFail($id)->first();
    }

    public function create(array $data): ? Admin_cabang
    {
        return Admin_cabang::create([$data]);
    }

    public function update(int $id, array $data): Admin_cabang
    {
        $admin_cabang = Admin_cabang::where('id', $id);
        $admin_cabang->update([$data]);
        return $admin_cabang;
    }

    public function delete(int $id): void
    {
        Admin_cabang::findOrFail($id)->delete();
    }
}