<?php

namespace Database\Seeders;

use App\models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $adminUser = User::create([
            'id' => Str::uuid(),
            'name' => 'Admin',
            'email' => 'admin@example',
            'password' => bcrypt('password'),
        ]);
        $adminUser->assignRole('admin');

        $mentorUser = User::create([
            'id' => Str::uuid(),
            'name' => 'Mentor',
            'email' => 'mentor@example',
            'password' => bcrypt('password'),
        ]);
        $mentorUser->assignRole('mentor');

        $superadminUser = User::create([
            'id' => Str::uuid(),
            'name' => 'Super Admin',
            'email' => 'superadmin@example',
            'password' => bcrypt('password'),
        ]);
        $superadminUser->assignRole('superadmin');
    }
}
