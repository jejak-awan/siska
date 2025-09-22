<?php

namespace Database\Seeders\Core;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed License Management
        $this->seedLicenses();
        
        // Seed School Profiles
        $this->seedSchoolProfiles();
        
        // Seed Academic Years
        $this->seedAcademicYears();
    }

    private function seedLicenses(): void
    {
        $licenses = [
            [
                'license_key' => 'SISKA-BASIC-001',
                'license_type' => 'basic',
                'jenjang_access' => json_encode(['SD']),
                'features' => json_encode(['kesiswaan']),
                'max_users' => 25,
                'expires_at' => Carbon::now()->addYear(),
                'is_active' => true,
                'activated_at' => Carbon::now()->subDays(30),
                'last_check' => Carbon::now()->subDays(1),
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'license_key' => 'SISKA-PREMIUM-002',
                'license_type' => 'premium',
                'jenjang_access' => json_encode(['SMP', 'SMA']),
                'features' => json_encode(['kesiswaan', 'akademik', 'keuangan']),
                'max_users' => 100,
                'expires_at' => Carbon::now()->addMonths(6),
                'is_active' => true,
                'activated_at' => Carbon::now()->subDays(15),
                'last_check' => Carbon::now()->subHours(6),
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subHours(6),
            ],
            [
                'license_key' => 'SISKA-ENTERPRISE-003',
                'license_type' => 'enterprise',
                'jenjang_access' => json_encode(['SD', 'SMP', 'SMA', 'SMK']),
                'features' => json_encode(['kesiswaan', 'akademik', 'keuangan', 'perpustakaan', 'inventaris']),
                'max_users' => 500,
                'expires_at' => Carbon::now()->addYears(2),
                'is_active' => true,
                'activated_at' => Carbon::now()->subDays(7),
                'last_check' => Carbon::now()->subHours(2),
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subHours(2),
            ],
            [
                'license_key' => 'SISKA-TRIAL-004',
                'license_type' => 'trial',
                'jenjang_access' => json_encode(['SMK']),
                'features' => json_encode(['kesiswaan']),
                'max_users' => 10,
                'expires_at' => Carbon::now()->addDays(14),
                'is_active' => false,
                'activated_at' => null,
                'last_check' => null,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'license_key' => 'SISKA-BASIC-005',
                'license_type' => 'basic',
                'jenjang_access' => json_encode(['SMP']),
                'features' => json_encode(['kesiswaan', 'akademik']),
                'max_users' => 50,
                'expires_at' => Carbon::now()->subDays(10), // Expired
                'is_active' => false,
                'activated_at' => Carbon::now()->subDays(60),
                'last_check' => Carbon::now()->subDays(15),
                'created_at' => Carbon::now()->subDays(60),
                'updated_at' => Carbon::now()->subDays(15),
            ],
        ];

        DB::table('license_management')->insert($licenses);
    }

    private function seedSchoolProfiles(): void
    {
        $schools = [
            [
                'sekolah_id' => 1001,
                'nama_sekolah' => 'SD Negeri 1 Jakarta Pusat',
                'npsn' => '20100101',
                'jenjang' => 'SD',
                'alamat' => 'Jl. Merdeka Selatan No. 1',
                'kota' => 'Jakarta Pusat',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => '10110',
                'telepon' => '021-1234567',
                'email' => 'info@sd1jakpus.sch.id',
                'website' => 'www.sd1jakpus.sch.id',
                'logo_url' => null,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'sekolah_id' => 1002,
                'nama_sekolah' => 'SMP Negeri 2 Bandung',
                'npsn' => '20200102',
                'jenjang' => 'SMP',
                'alamat' => 'Jl. Asia Afrika No. 65',
                'kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '40111',
                'telepon' => '022-1234567',
                'email' => 'info@smp2bandung.sch.id',
                'website' => 'www.smp2bandung.sch.id',
                'logo_url' => null,
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'sekolah_id' => 1003,
                'nama_sekolah' => 'SMA Negeri 3 Yogyakarta',
                'npsn' => '20400103',
                'jenjang' => 'SMA',
                'alamat' => 'Jl. Yos Sudarso No. 7',
                'kota' => 'Yogyakarta',
                'provinsi' => 'DI Yogyakarta',
                'kode_pos' => '55111',
                'telepon' => '0274-1234567',
                'email' => 'info@sma3yogya.sch.id',
                'website' => 'www.sma3yogya.sch.id',
                'logo_url' => null,
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'sekolah_id' => 1004,
                'nama_sekolah' => 'SMK Negeri 4 Surabaya',
                'npsn' => '20500104',
                'jenjang' => 'SMK',
                'alamat' => 'Jl. Raya Darmo No. 88',
                'kota' => 'Surabaya',
                'provinsi' => 'Jawa Timur',
                'kode_pos' => '60265',
                'telepon' => '031-1234567',
                'email' => 'info@smk4surabaya.sch.id',
                'website' => 'www.smk4surabaya.sch.id',
                'logo_url' => null,
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subHours(12),
            ],
            [
                'sekolah_id' => 1005,
                'nama_sekolah' => 'SD Islam Terpadu Al-Azhar',
                'npsn' => '20100105',
                'jenjang' => 'SD',
                'alamat' => 'Jl. Sisingamangaraja No. 1',
                'kota' => 'Jakarta Selatan',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => '12110',
                'telepon' => '021-7654321',
                'email' => 'info@sditalazhar.sch.id',
                'website' => 'www.sditalazhar.sch.id',
                'logo_url' => null,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subHours(6),
            ],
            [
                'sekolah_id' => 1006,
                'nama_sekolah' => 'SMP Swasta Bina Nusantara',
                'npsn' => '20200106',
                'jenjang' => 'SMP',
                'alamat' => 'Jl. Kemang Raya No. 45',
                'kota' => 'Jakarta Selatan',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => '12730',
                'telepon' => '021-9876543',
                'email' => 'info@smpbinus.sch.id',
                'website' => 'www.smpbinus.sch.id',
                'logo_url' => null,
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subHours(3),
            ],
            [
                'sekolah_id' => 1007,
                'nama_sekolah' => 'SMA Negeri 1 Medan',
                'npsn' => '20400107',
                'jenjang' => 'SMA',
                'alamat' => 'Jl. Gatot Subroto No. 12',
                'kota' => 'Medan',
                'provinsi' => 'Sumatera Utara',
                'kode_pos' => '20112',
                'telepon' => '061-1234567',
                'email' => 'info@sma1medan.sch.id',
                'website' => 'www.sma1medan.sch.id',
                'logo_url' => null,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subHours(1),
            ],
            [
                'sekolah_id' => 1008,
                'nama_sekolah' => 'SMK Teknologi Informatika',
                'npsn' => '20500108',
                'jenjang' => 'SMK',
                'alamat' => 'Jl. Raya Bogor Km. 30',
                'kota' => 'Depok',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '16431',
                'telepon' => '021-8765432',
                'email' => 'info@smkti.sch.id',
                'website' => 'www.smkti.sch.id',
                'logo_url' => null,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subMinutes(30),
            ],
        ];

        DB::table('profil_sekolah')->insert($schools);
    }

    private function seedAcademicYears(): void
    {
        $academicYears = [
            [
                'sekolah_id' => 1001,
                'tahun_mulai' => 2024,
                'tahun_selesai' => 2025,
                'semester_aktif' => 1,
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'sekolah_id' => 1002,
                'tahun_mulai' => 2024,
                'tahun_selesai' => 2025,
                'semester_aktif' => 1,
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'sekolah_id' => 1003,
                'tahun_mulai' => 2024,
                'tahun_selesai' => 2025,
                'semester_aktif' => 1,
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'sekolah_id' => 1004,
                'tahun_mulai' => 2024,
                'tahun_selesai' => 2025,
                'semester_aktif' => 1,
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subHours(12),
            ],
            [
                'sekolah_id' => 1005,
                'tahun_mulai' => 2024,
                'tahun_selesai' => 2025,
                'semester_aktif' => 1,
                'is_active' => false,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subHours(6),
            ],
            [
                'sekolah_id' => 1006,
                'tahun_mulai' => 2023,
                'tahun_selesai' => 2024,
                'semester_aktif' => 2,
                'is_active' => false,
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subHours(3),
            ],
            [
                'sekolah_id' => 1007,
                'tahun_mulai' => 2024,
                'tahun_selesai' => 2025,
                'semester_aktif' => 1,
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subHours(1),
            ],
            [
                'sekolah_id' => 1008,
                'tahun_mulai' => 2024,
                'tahun_selesai' => 2025,
                'semester_aktif' => 1,
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subMinutes(30),
            ],
        ];

        DB::table('tahun_akademik')->insert($academicYears);
    }
}
