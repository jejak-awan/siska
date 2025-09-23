<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAkademik;
use Carbon\Carbon;

class TahunAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first school profile ID
        $schoolId = \App\Models\SchoolProfile::first()->id;
        
        $academicYears = [
            [
                'sekolah_id' => $schoolId,
                'tahun_akademik' => '2024/2025',
                'tanggal_mulai' => Carbon::create(2024, 7, 15),
                'tanggal_selesai' => Carbon::create(2024, 12, 20),
                'status' => 'completed',
                'is_active' => false,
                'keterangan' => 'Tahun akademik 2024/2025 semester ganjil',
                'created_at' => Carbon::now()->subDays(180),
                'updated_at' => Carbon::now()->subDays(30),
            ],
            [
                'sekolah_id' => $schoolId,
                'tahun_akademik' => '2024/2025',
                'tanggal_mulai' => Carbon::create(2025, 1, 6),
                'tanggal_selesai' => Carbon::create(2025, 6, 20),
                'status' => 'active',
                'is_active' => true,
                'keterangan' => 'Tahun akademik 2024/2025 semester genap',
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now(),
            ],
            [
                'sekolah_id' => $schoolId,
                'tahun_akademik' => '2025/2026',
                'tanggal_mulai' => Carbon::create(2025, 7, 15),
                'tanggal_selesai' => Carbon::create(2025, 12, 20),
                'status' => 'upcoming',
                'is_active' => false,
                'keterangan' => 'Tahun akademik 2025/2026 semester ganjil',
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(5),
            ]
        ];

        foreach ($academicYears as $year) {
            TahunAkademik::create($year);
        }

        $this->command->info('TahunAkademik seeder berhasil dijalankan!');
    }
}
