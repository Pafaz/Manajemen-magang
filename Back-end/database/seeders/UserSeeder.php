<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'telepon' => '08123456789',
            'password' => bcrypt('password')
        ],
    [
        'name' => 'Super Admin',
        'email' => 'superadmin@gmail.com',
        'telepon' => '08123456743',
        'password' => bcrypt('password')
    ],
    [
        'name' => 'Mentor',
        'email' => 'mentor@gmail.com',
        'telepon' => '08123456003',
        'password' => bcrypt('password')
    ]);
    }
}
