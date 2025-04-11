<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'perusahaan']);
        Role::create(['name' => 'peserta']);
        Role::create(['name' => 'mentor']);

        // Role::create(['id' => Str::uuid()->toString(), 'name' => 'superadmin']);
        // Role::create(['id' => Str::uuid()->toString(), 'name' => 'admin']);
        // Role::create(['id' => Str::uuid()->toString(), 'name' => 'perusahaan']);
        // Role::create(['id' => Str::uuid()->toString(), 'name' => 'peserta']);
        // Role::create(['id' => Str::uuid()->toString(), 'name' => 'mentor']);
    }
}
