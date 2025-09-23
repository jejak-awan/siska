<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolProfile;
use Carbon\Carbon;

class SchoolProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = [
            [
                'npsn' => '20100101',
                'nama_sekolah' => 'SD Negeri 1 Jakarta Pusat',
                'jenjang' => 'SD',
                'alamat' => 'Jl. Merdeka Selatan No. 1, Jakarta Pusat, DKI Jakarta 10110',
                'kelurahan' => 'Gambir',
                'kecamatan' => 'Gambir',
                'kabupaten_kota' => 'Jakarta Pusat',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => '10110',
                'nomor_telepon' => '021-1234567',
                'email' => 'info@sd1jakpus.sch.id',
                'website' => 'www.sd1jakpus.sch.id',
                'logo_url' => null,
                'jenjang_aktif' => json_encode(['SD']),
                'tahun_berdiri' => 1950,
                'status_sekolah' => 'negeri',
                'akreditasi' => 'A',
                'kepala_sekolah' => 'Dr. Siti Aminah, M.Pd',
                'nip_kepala_sekolah' => '196001011980032001',
                'bendahara' => 'Budi Santoso',
                'nip_bendahara' => '196501011980032002',
                'operator' => 'Siti Rahayu',
                'nip_operator' => '197001011980032003',
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'is_active' => 1,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'npsn' => '20100202',
                'nama_sekolah' => 'SMP Negeri 1 Jakarta Selatan',
                'jenjang' => 'SMP',
                'alamat' => 'Jl. Gatot Subroto No. 10, Jakarta Selatan, DKI Jakarta 12190',
                'kelurahan' => 'Kebayoran Baru',
                'kecamatan' => 'Kebayoran Baru',
                'kabupaten_kota' => 'Jakarta Selatan',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => '12190',
                'nomor_telepon' => '021-2345678',
                'email' => 'info@smp1jaksels.sch.id',
                'website' => 'www.smp1jaksels.sch.id',
                'logo_url' => null,
                'jenjang_aktif' => json_encode(['SMP']),
                'tahun_berdiri' => 1965,
                'status_sekolah' => 'negeri',
                'akreditasi' => 'A',
                'kepala_sekolah' => 'Drs. Budi Santoso, M.Pd',
                'nip_kepala_sekolah' => '196501011980032001',
                'bendahara' => 'Siti Rahayu',
                'nip_bendahara' => '197001011980032002',
                'operator' => 'Ahmad Fauzi',
                'nip_operator' => '197501011980032003',
                'latitude' => -6.2297,
                'longitude' => 106.7995,
                'is_active' => 1,
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'npsn' => '20100303',
                'nama_sekolah' => 'SMA Negeri 1 Jakarta Timur',
                'jenjang' => 'SMA',
                'alamat' => 'Jl. Raya Bekasi Km. 15, Jakarta Timur, DKI Jakarta 13410',
                'kelurahan' => 'Cakung',
                'kecamatan' => 'Cakung',
                'kabupaten_kota' => 'Jakarta Timur',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => '13410',
                'nomor_telepon' => '021-3456789',
                'email' => 'info@sma1jaktim.sch.id',
                'website' => 'www.sma1jaktim.sch.id',
                'logo_url' => null,
                'jenjang_aktif' => json_encode(['SMA']),
                'tahun_berdiri' => 1970,
                'status_sekolah' => 'negeri',
                'akreditasi' => 'A',
                'kepala_sekolah' => 'Dra. Rina Wijayanti, M.Pd',
                'nip_kepala_sekolah' => '197001011980032001',
                'bendahara' => 'Budi Santoso',
                'nip_bendahara' => '197501011980032002',
                'operator' => 'Siti Rahayu',
                'nip_operator' => '198001011980032003',
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'is_active' => 1,
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'npsn' => '20100404',
                'nama_sekolah' => 'SMK Negeri 1 Jakarta Utara',
                'jenjang' => 'SMK',
                'alamat' => 'Jl. Raya Cilincing No. 5, Jakarta Utara, DKI Jakarta 14110',
                'kelurahan' => 'Cilincing',
                'kecamatan' => 'Cilincing',
                'kabupaten_kota' => 'Jakarta Utara',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => '14110',
                'nomor_telepon' => '021-4567890',
                'email' => 'info@smk1jakut.sch.id',
                'website' => 'www.smk1jakut.sch.id',
                'logo_url' => null,
                'jenjang_aktif' => json_encode(['SMK']),
                'tahun_berdiri' => 1980,
                'status_sekolah' => 'negeri',
                'akreditasi' => 'A',
                'kepala_sekolah' => 'Ir. Ahmad Fauzi, M.T',
                'nip_kepala_sekolah' => '198001011980032001',
                'bendahara' => 'Siti Rahayu',
                'nip_bendahara' => '198501011980032002',
                'operator' => 'Budi Santoso',
                'nip_operator' => '199001011980032003',
                'latitude' => -6.1088,
                'longitude' => 106.9456,
                'is_active' => 1,
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now(),
            ]
        ];

        foreach ($schools as $school) {
            SchoolProfile::create($school);
        }

        $this->command->info('SchoolProfile seeder berhasil dijalankan!');
    }
}
