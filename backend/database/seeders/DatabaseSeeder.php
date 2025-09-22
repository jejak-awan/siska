<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Database Seeder untuk SISKA Backend System
 * 
 * @package Database\Seeders
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SampleDataSeeder::class,
        ]);
    }
}
