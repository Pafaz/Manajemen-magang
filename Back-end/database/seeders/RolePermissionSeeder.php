<?php

namespace Database\Seeders;

use App\Models\User;
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
        Role::create(['name' => 'superadmin', 'guard_name' => 'api']);
        Role::create(['name' => 'admin', 'guard_name' => 'api']);
        Role::create(['name' => 'perusahaan', 'guard_name' => 'api']);
        Role::create(['name' => 'peserta', 'guard_name' => 'api']);
        Role::create(['name' => 'mentor', 'guard_name' => 'api']);

        $user = User::create([
            'id' => Str::uuid(),
            'nama' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'telepon' => '089231233301',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('superadmin');
    }
}
