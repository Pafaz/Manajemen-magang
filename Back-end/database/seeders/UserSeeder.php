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
            'role'=> 'admin',
            'telepon' => '08123456789',
            'password' => bcrypt('password')
        ]);
        User::create([
        'name' => 'Super Admin',
        'email' => 'superadmin@gmail.com',
        'role'=> 'superadmin',
        'telepon' => '08123456743',
        'password' => bcrypt('password')
        ]);
        User::create([
        'name' => 'Mentor',
        'email' => 'mentor@gmail.com',
        'role'=> 'mentor',
        'telepon' => '08123456003',
        'password' => bcrypt('password')
        ]);
        User::create([
            'name' => 'elang',
            'email' => 'elangprakoso088@gmail.com',
            'role'=> 'peserta',
            'telepon' => '08193456003',
            'password' => bcrypt('password')
        ]);
    }
}
