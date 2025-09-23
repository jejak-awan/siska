<?php

namespace Jenjang\SD\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SDSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed SD Users
        $this->seedSDUsers();
        
        // Seed SD Students
        $this->seedSDStudents();
        
        // Seed SD Extracurriculars
        $this->seedSDExtracurriculars();
        
        // Seed SD Student Programs
        $this->seedSDStudentPrograms();
    }

    private function seedSDUsers(): void
    {
        $users = [
            [
                'name' => 'Admin SD',
                'email' => 'admin@sd1jakpus.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'admin',
                'jenjang' => 'SD',
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'name' => 'Guru SD 1',
                'email' => 'guru1@sd1jakpus.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'guru',
                'jenjang' => 'SD',
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'name' => 'Guru SD 2',
                'email' => 'guru2@sd1jakpus.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'guru',
                'jenjang' => 'SD',
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];

        DB::table('users_sd')->insert($users);
    }

    private function seedSDStudents(): void
    {
        $students = [
            [
                'nis' => 'SD001',
                'nisn' => '1234567890',
                'nama_lengkap' => 'Ahmad Rizki Pratama',
                'nama_panggilan' => 'Ahmad',
                'kelas' => '1A',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2018-03-15',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta Pusat',
                'nama_orang_tua' => 'Budi Pratama',
                'telepon_orang_tua' => '081234567890',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'nis' => 'SD002',
                'nisn' => '1234567891',
                'nama_lengkap' => 'Siti Nurhaliza',
                'nama_panggilan' => 'Siti',
                'kelas' => '1A',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2018-05-20',
                'alamat' => 'Jl. Sudirman No. 25, Jakarta Pusat',
                'nama_orang_tua' => 'Ahmad Nurhaliza',
                'telepon_orang_tua' => '081234567891',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(29),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'nis' => 'SD003',
                'nisn' => '1234567892',
                'nama_lengkap' => 'Muhammad Fauzi',
                'nama_panggilan' => 'Fauzi',
                'kelas' => '2A',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2017-08-10',
                'alamat' => 'Jl. Thamrin No. 15, Jakarta Pusat',
                'nama_orang_tua' => 'Hasan Fauzi',
                'telepon_orang_tua' => '081234567892',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(28),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'nis' => 'SD004',
                'nisn' => '1234567893',
                'nama_lengkap' => 'Fatimah Azzahra',
                'nama_panggilan' => 'Fatimah',
                'kelas' => '2A',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2017-11-25',
                'alamat' => 'Jl. Gatot Subroto No. 30, Jakarta Pusat',
                'nama_orang_tua' => 'Ali Azzahra',
                'telepon_orang_tua' => '081234567893',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(27),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'nis' => 'SD005',
                'nisn' => '1234567894',
                'nama_lengkap' => 'Ibrahim Khalil',
                'nama_panggilan' => 'Ibrahim',
                'kelas' => '3A',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2016-02-14',
                'alamat' => 'Jl. Kuningan No. 20, Jakarta Pusat',
                'nama_orang_tua' => 'Umar Khalil',
                'telepon_orang_tua' => '081234567894',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(26),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];

        DB::table('siswa_sd')->insert($students);
    }

    private function seedSDExtracurriculars(): void
    {
        $extracurriculars = [
            [
                'nama_ekstrakurikuler' => 'Pramuka',
                'deskripsi' => 'Kegiatan kepramukaan untuk melatih kedisiplinan dan kepemimpinan',
                'pembina' => 'Guru SD 1',
                'jadwal' => 'Sabtu, 08:00 - 10:00',
                'lokasi' => 'Lapangan Sekolah',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'nama_ekstrakurikuler' => 'Seni Tari',
                'deskripsi' => 'Kegiatan menari untuk mengembangkan bakat seni siswa',
                'pembina' => 'Guru SD 2',
                'jadwal' => 'Rabu, 14:00 - 16:00',
                'lokasi' => 'Aula Sekolah',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'nama_ekstrakurikuler' => 'Olahraga',
                'deskripsi' => 'Kegiatan olahraga untuk menjaga kesehatan dan kebugaran',
                'pembina' => 'Guru SD 1',
                'jadwal' => 'Kamis, 15:00 - 17:00',
                'lokasi' => 'Lapangan Sekolah',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];

        DB::table('ekstrakurikuler_sd')->insert($extracurriculars);
    }

    private function seedSDStudentPrograms(): void
    {
        $programs = [
            [
                'nama_program' => 'Program Literasi Dasar',
                'deskripsi' => 'Program untuk meningkatkan kemampuan membaca dan menulis siswa kelas 1-3',
                'tanggal_mulai' => '2024-08-01',
                'tanggal_selesai' => '2024-12-31',
                'penanggung_jawab' => 'Guru SD 1',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'nama_program' => 'Program Karakter Bangsa',
                'deskripsi' => 'Program untuk menanamkan nilai-nilai karakter bangsa pada siswa',
                'tanggal_mulai' => '2024-09-01',
                'tanggal_selesai' => '2025-01-31',
                'penanggung_jawab' => 'Guru SD 2',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
        ];

        DB::table('program_kesiswaan_sd')->insert($programs);
    }
}

