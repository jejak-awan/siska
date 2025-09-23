<?php

namespace Jenjang\SMA\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SMASampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed SMA Users
        $this->seedSMAUsers();
        
        // Seed SMA Students
        $this->seedSMAStudents();
        
        // Seed SMA Organizations
        $this->seedSMAOrganizations();
        
        // Seed SMA Student Programs
        $this->seedSMAStudentPrograms();
    }

    private function seedSMAUsers(): void
    {
        $users = [
            [
                'name' => 'Admin SMA',
                'email' => 'admin@sma3yogya.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'admin',
                'jenjang' => 'SMA',
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'name' => 'Guru SMA 1',
                'email' => 'guru1@sma3yogya.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'guru',
                'jenjang' => 'SMA',
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'name' => 'Guru SMA 2',
                'email' => 'guru2@sma3yogya.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'guru',
                'jenjang' => 'SMA',
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];

        DB::table('users_sma')->insert($users);
    }

    private function seedSMAStudents(): void
    {
        $students = [
            [
                'nis' => 'SMA001',
                'nisn' => '3234567890',
                'nama_lengkap' => 'Ahmad Rizki Pratama',
                'nama_panggilan' => 'Ahmad',
                'kelas' => '10A',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2008-03-15',
                'alamat' => 'Jl. Malioboro No. 10, Yogyakarta',
                'nama_orang_tua' => 'Budi Pratama',
                'telepon_orang_tua' => '081234567890',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'nis' => 'SMA002',
                'nisn' => '3234567891',
                'nama_lengkap' => 'Siti Nurhaliza',
                'nama_panggilan' => 'Siti',
                'kelas' => '10A',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2008-05-20',
                'alamat' => 'Jl. Sudirman No. 25, Yogyakarta',
                'nama_orang_tua' => 'Ahmad Nurhaliza',
                'telepon_orang_tua' => '081234567891',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(29),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'nis' => 'SMA003',
                'nisn' => '3234567892',
                'nama_lengkap' => 'Muhammad Fauzi',
                'nama_panggilan' => 'Fauzi',
                'kelas' => '11A',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2007-08-10',
                'alamat' => 'Jl. Thamrin No. 15, Yogyakarta',
                'nama_orang_tua' => 'Hasan Fauzi',
                'telepon_orang_tua' => '081234567892',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(28),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'nis' => 'SMA004',
                'nisn' => '3234567893',
                'nama_lengkap' => 'Fatimah Azzahra',
                'nama_panggilan' => 'Fatimah',
                'kelas' => '11A',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2007-11-25',
                'alamat' => 'Jl. Gatot Subroto No. 30, Yogyakarta',
                'nama_orang_tua' => 'Ali Azzahra',
                'telepon_orang_tua' => '081234567893',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(27),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'nis' => 'SMA005',
                'nisn' => '3234567894',
                'nama_lengkap' => 'Ibrahim Khalil',
                'nama_panggilan' => 'Ibrahim',
                'kelas' => '12A',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2006-02-14',
                'alamat' => 'Jl. Kuningan No. 20, Yogyakarta',
                'nama_orang_tua' => 'Umar Khalil',
                'telepon_orang_tua' => '081234567894',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(26),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];

        DB::table('siswa_sma')->insert($students);
    }

    private function seedSMAOrganizations(): void
    {
        $organizations = [
            [
                'nama_organisasi' => 'OSIS',
                'deskripsi' => 'Organisasi Siswa Intra Sekolah',
                'pembina' => 'Guru SMA 1',
                'jadwal' => 'Jumat, 14:00 - 16:00',
                'lokasi' => 'Ruang OSIS',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'nama_organisasi' => 'Pramuka',
                'deskripsi' => 'Gerakan Pramuka Gugus Depan',
                'pembina' => 'Guru SMA 2',
                'jadwal' => 'Sabtu, 08:00 - 12:00',
                'lokasi' => 'Lapangan Sekolah',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'nama_organisasi' => 'Rohis',
                'deskripsi' => 'Rohani Islam',
                'pembina' => 'Guru SMA 1',
                'jadwal' => 'Rabu, 15:00 - 17:00',
                'lokasi' => 'Masjid Sekolah',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];

        DB::table('organisasi_sma')->insert($organizations);
    }

    private function seedSMAStudentPrograms(): void
    {
        $programs = [
            [
                'nama_program' => 'Program Kreativitas Siswa',
                'deskripsi' => 'Program untuk mengembangkan kreativitas dan inovasi siswa',
                'tanggal_mulai' => '2024-08-01',
                'tanggal_selesai' => '2024-12-31',
                'penanggung_jawab' => 'Guru SMA 1',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'nama_program' => 'Program Kepemimpinan',
                'deskripsi' => 'Program untuk melatih kemampuan kepemimpinan siswa',
                'tanggal_mulai' => '2024-09-01',
                'tanggal_selesai' => '2025-01-31',
                'penanggung_jawab' => 'Guru SMA 2',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
        ];

        DB::table('program_kesiswaan_sma')->insert($programs);
    }
}

