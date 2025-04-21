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
        Role::create(['name' => 'perusahaan', 'guard_name' => 'web']);
        Role::create(['name' => 'peserta', 'guard_name' => 'web']);
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'mentor', 'guard_name' => 'web']);
        Role::create(['name' => 'superadmin', 'guard_name' => 'web']);


        // Role::create(['id' => Str::uuid()->toString(), 'name' => 'superadmin']);
        // Role::create(['id' => Str::uuid()->toString(), 'name' => 'admin']);
        // Role::create(['id' => Str::uuid()->toString(), 'name' => 'perusahaan']);
        // Role::create(['id' => Str::uuid()->toString(), 'name' => 'peserta']);
        // Role::create(['id' => Str::uuid()->toString(), 'name' => 'mentor']);
    }
}
