<?php

namespace App\Repositories;

use App\Models\Cabang;
use Illuminate\Support\Str;
use App\Models\Admin_cabang;
use App\Interfaces\AdminInterface;
use Illuminate\Database\Eloquent\Collection;

class AdminRepository implements AdminInterface
{
    public function getAll(): Collection
    {
        return Admin_cabang::all();
    }

    public function getByCabang($id_cabang)
    {
        return Admin_cabang::where('id_cabang', $id_cabang)->first();
    }

    public function find(int $id): ? Admin_cabang
    {
        return Admin_cabang::findOrFail($id)->first();
    }

    public function findByUser($id): ? Cabang
    {
        return Cabang::where('id_cabang', $id)->first();
    }

    public function create(array $data): ? Admin_cabang
    {       
        return Admin_cabang::create($data);
    }

    public function update(int $id, array $data): Admin_cabang
    {
        $admin_cabang = Admin_cabang::findOrFail($id);
        $admin_cabang->update($data);
        return $admin_cabang;
    }

    public function delete(int $id): void
    {
        Admin_cabang::findOrFail($id)->delete();
    }
}