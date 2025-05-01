<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\PesertaSeeder;
use Database\Seeders\PerusahaanSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\SekolahJurusanSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            // PerusahaanSeeder::class,
            // UserSeeder::class,
            // SekolahJurusanSeeder::class,
            // PesertaSeeder::class,
        ]);
    }
}