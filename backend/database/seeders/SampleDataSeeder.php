<?php

namespace Database\Seeders;

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
                'license_key' => 'SISKA-SINGLE-001',
                'license_type' => 'single',
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
                'license_key' => 'SISKA-MULTI-002',
                'license_type' => 'multi',
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
                'license_key' => 'SISKA-SINGLE-005',
                'license_type' => 'single',
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
                'nama_sekolah' => 'SD Negeri 1 Jakarta Pusat',
                'jenis_sekolah' => 'negeri',
                'jenjang_aktif' => json_encode(['SD']),
                'multi_jenjang' => false,
                'alamat' => 'Jl. Merdeka Selatan No. 1, Jakarta Pusat, DKI Jakarta 10110',
                'telepon' => '021-1234567',
                'email' => 'info@sd1jakpus.sch.id',
                'website' => 'www.sd1jakpus.sch.id',
                'logo' => null,
                'npsn' => '20100101',
                'akreditasi' => 'A',
                'kepala_sekolah' => 'Dr. Siti Aminah, M.Pd',
                'tahun_berdiri' => 1950,
                'status' => 1,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'nama_sekolah' => 'SMP Negeri 2 Bandung',
                'jenis_sekolah' => 'negeri',
                'jenjang_aktif' => json_encode(['SMP']),
                'multi_jenjang' => false,
                'alamat' => 'Jl. Asia Afrika No. 65, Bandung, Jawa Barat 40111',
                'telepon' => '022-1234567',
                'email' => 'info@smp2bandung.sch.id',
                'website' => 'www.smp2bandung.sch.id',
                'logo' => null,
                'npsn' => '20200102',
                'akreditasi' => 'A',
                'kepala_sekolah' => 'Drs. Budi Santoso, M.Pd',
                'tahun_berdiri' => 1965,
                'status' => 1,
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'nama_sekolah' => 'SMA Negeri 3 Yogyakarta',
                'jenis_sekolah' => 'negeri',
                'jenjang_aktif' => json_encode(['SMA']),
                'multi_jenjang' => false,
                'alamat' => 'Jl. Yos Sudarso No. 7, Yogyakarta, DI Yogyakarta 55111',
                'telepon' => '0274-1234567',
                'email' => 'info@sma3yogya.sch.id',
                'website' => 'www.sma3yogya.sch.id',
                'logo' => null,
                'npsn' => '20400103',
                'akreditasi' => 'A',
                'kepala_sekolah' => 'Dra. Endang Sari, M.Pd',
                'tahun_berdiri' => 1970,
                'status' => 1,
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'nama_sekolah' => 'SMK Negeri 4 Surabaya',
                'jenis_sekolah' => 'negeri',
                'jenjang_aktif' => json_encode(['SMK']),
                'multi_jenjang' => false,
                'alamat' => 'Jl. Raya Darmo No. 88, Surabaya, Jawa Timur 60265',
                'telepon' => '031-1234567',
                'email' => 'info@smk4surabaya.sch.id',
                'website' => 'www.smk4surabaya.sch.id',
                'logo' => null,
                'npsn' => '20500104',
                'akreditasi' => 'A',
                'kepala_sekolah' => 'Ir. Ahmad Fauzi, M.T',
                'tahun_berdiri' => 1980,
                'status' => 1,
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subHours(12),
            ],
            [
                'nama_sekolah' => 'SD Islam Terpadu Al-Azhar',
                'jenis_sekolah' => 'swasta',
                'jenjang_aktif' => json_encode(['SD']),
                'multi_jenjang' => false,
                'alamat' => 'Jl. Sisingamangaraja No. 1, Jakarta Selatan, DKI Jakarta 12110',
                'telepon' => '021-7654321',
                'email' => 'info@sditalazhar.sch.id',
                'website' => 'www.sditalazhar.sch.id',
                'logo' => null,
                'npsn' => '20100105',
                'akreditasi' => 'A',
                'kepala_sekolah' => 'Hj. Fatimah Zahra, S.Pd.I',
                'tahun_berdiri' => 1990,
                'status' => 1,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subHours(6),
            ],
            [
                'nama_sekolah' => 'SMP Swasta Bina Nusantara',
                'jenis_sekolah' => 'swasta',
                'jenjang_aktif' => json_encode(['SMP']),
                'multi_jenjang' => false,
                'alamat' => 'Jl. Kemang Raya No. 45, Jakarta Selatan, DKI Jakarta 12730',
                'telepon' => '021-9876543',
                'email' => 'info@smpbinus.sch.id',
                'website' => 'www.smpbinus.sch.id',
                'logo' => null,
                'npsn' => '20200106',
                'akreditasi' => 'A',
                'kepala_sekolah' => 'Drs. Robert Kurniawan, M.Pd',
                'tahun_berdiri' => 1995,
                'status' => 1,
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subHours(3),
            ],
            [
                'nama_sekolah' => 'SMA Negeri 1 Medan',
                'jenis_sekolah' => 'negeri',
                'jenjang_aktif' => json_encode(['SMA']),
                'multi_jenjang' => false,
                'alamat' => 'Jl. Gatot Subroto No. 12, Medan, Sumatera Utara 20112',
                'telepon' => '061-1234567',
                'email' => 'info@sma1medan.sch.id',
                'website' => 'www.sma1medan.sch.id',
                'logo' => null,
                'npsn' => '20400107',
                'akreditasi' => 'A',
                'kepala_sekolah' => 'Drs. Suryadi, M.Pd',
                'tahun_berdiri' => 1960,
                'status' => 1,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subHours(1),
            ],
            [
                'nama_sekolah' => 'SMK Teknologi Informatika',
                'jenis_sekolah' => 'swasta',
                'jenjang_aktif' => json_encode(['SMK']),
                'multi_jenjang' => false,
                'alamat' => 'Jl. Raya Bogor Km. 30, Depok, Jawa Barat 16431',
                'telepon' => '021-8765432',
                'email' => 'info@smkti.sch.id',
                'website' => 'www.smkti.sch.id',
                'logo' => null,
                'npsn' => '20500108',
                'akreditasi' => 'A',
                'kepala_sekolah' => 'Ir. Bambang Sutrisno, M.T',
                'tahun_berdiri' => 2000,
                'status' => 1,
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
                'sekolah_id' => 1,
                'tahun_akademik' => '2024/2025',
                'tanggal_mulai' => '2024-07-15',
                'tanggal_selesai' => '2025-06-30',
                'status' => 'active',
                'is_active' => true,
                'keterangan' => 'Tahun akademik aktif untuk SD Negeri 1 Jakarta Pusat',
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'sekolah_id' => 2,
                'tahun_akademik' => '2024/2025',
                'tanggal_mulai' => '2024-07-15',
                'tanggal_selesai' => '2025-06-30',
                'status' => 'active',
                'is_active' => true,
                'keterangan' => 'Tahun akademik aktif untuk SMP Negeri 2 Bandung',
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'sekolah_id' => 3,
                'tahun_akademik' => '2024/2025',
                'tanggal_mulai' => '2024-07-15',
                'tanggal_selesai' => '2025-06-30',
                'status' => 'active',
                'is_active' => true,
                'keterangan' => 'Tahun akademik aktif untuk SMA Negeri 3 Yogyakarta',
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'sekolah_id' => 4,
                'tahun_akademik' => '2024/2025',
                'tanggal_mulai' => '2024-07-15',
                'tanggal_selesai' => '2025-06-30',
                'status' => 'active',
                'is_active' => true,
                'keterangan' => 'Tahun akademik aktif untuk SMK Negeri 4 Surabaya',
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subHours(12),
            ],
            [
                'sekolah_id' => 5,
                'tahun_akademik' => '2024/2025',
                'tanggal_mulai' => '2024-07-15',
                'tanggal_selesai' => '2025-06-30',
                'status' => 'upcoming',
                'is_active' => false,
                'keterangan' => 'Tahun akademik akan dimulai untuk SD Islam Terpadu Al-Azhar',
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subHours(6),
            ],
            [
                'sekolah_id' => 6,
                'tahun_akademik' => '2023/2024',
                'tanggal_mulai' => '2023-07-15',
                'tanggal_selesai' => '2024-06-30',
                'status' => 'completed',
                'is_active' => false,
                'keterangan' => 'Tahun akademik selesai untuk SMP Swasta Bina Nusantara',
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subHours(3),
            ],
            [
                'sekolah_id' => 7,
                'tahun_akademik' => '2024/2025',
                'tanggal_mulai' => '2024-07-15',
                'tanggal_selesai' => '2025-06-30',
                'status' => 'active',
                'is_active' => true,
                'keterangan' => 'Tahun akademik aktif untuk SMA Negeri 1 Medan',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subHours(1),
            ],
            [
                'sekolah_id' => 8,
                'tahun_akademik' => '2024/2025',
                'tanggal_mulai' => '2024-07-15',
                'tanggal_selesai' => '2025-06-30',
                'status' => 'active',
                'is_active' => true,
                'keterangan' => 'Tahun akademik aktif untuk SMK Teknologi Informatika',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subMinutes(30),
            ],
        ];

        DB::table('tahun_akademik')->insert($academicYears);
    }
}
