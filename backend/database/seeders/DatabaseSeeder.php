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
            // Jenjang-specific seeders
            \Jenjang\SD\Database\Seeders\SDSampleDataSeeder::class,
            \Jenjang\SMP\Database\Seeders\SMPSampleDataSeeder::class,
            \Jenjang\SMA\Database\Seeders\SMASampleDataSeeder::class,
            \Jenjang\SMK\Database\Seeders\SMKSampleDataSeeder::class,
            // Presensi data
            PresensiSampleDataSeeder::class,
        ]);
    }
}
