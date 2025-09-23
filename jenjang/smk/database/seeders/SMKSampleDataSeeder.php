<?php

namespace Jenjang\SMK\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SMKSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed SMK Users
        $this->seedSMKUsers();
        
        // Seed SMK Students
        $this->seedSMKStudents();
        
        // Seed SMK Vocational Skills
        $this->seedSMKVocationalSkills();
        
        // Seed SMK Student Programs
        $this->seedSMKStudentPrograms();
    }

    private function seedSMKUsers(): void
    {
        $users = [
            [
                'name' => 'Admin SMK',
                'email' => 'admin@smk4surabaya.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'admin',
                'jenjang' => 'SMK',
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'name' => 'Guru SMK 1',
                'email' => 'guru1@smk4surabaya.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'guru',
                'jenjang' => 'SMK',
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'name' => 'Guru SMK 2',
                'email' => 'guru2@smk4surabaya.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'guru',
                'jenjang' => 'SMK',
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];

        DB::table('users_smk')->insert($users);
    }

    private function seedSMKStudents(): void
    {
        $students = [
            [
                'nis' => 'SMK001',
                'nisn' => '4234567890',
                'nama_lengkap' => 'Ahmad Rizki Pratama',
                'nama_panggilan' => 'Ahmad',
                'kelas' => '10TKJ',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2008-03-15',
                'alamat' => 'Jl. Raya Darmo No. 10, Surabaya',
                'nama_orang_tua' => 'Budi Pratama',
                'telepon_orang_tua' => '081234567890',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'nis' => 'SMK002',
                'nisn' => '4234567891',
                'nama_lengkap' => 'Siti Nurhaliza',
                'nama_panggilan' => 'Siti',
                'kelas' => '10TKJ',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2008-05-20',
                'alamat' => 'Jl. Sudirman No. 25, Surabaya',
                'nama_orang_tua' => 'Ahmad Nurhaliza',
                'telepon_orang_tua' => '081234567891',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(29),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'nis' => 'SMK003',
                'nisn' => '4234567892',
                'nama_lengkap' => 'Muhammad Fauzi',
                'nama_panggilan' => 'Fauzi',
                'kelas' => '11MM',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2007-08-10',
                'alamat' => 'Jl. Thamrin No. 15, Surabaya',
                'nama_orang_tua' => 'Hasan Fauzi',
                'telepon_orang_tua' => '081234567892',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(28),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'nis' => 'SMK004',
                'nisn' => '4234567893',
                'nama_lengkap' => 'Fatimah Azzahra',
                'nama_panggilan' => 'Fatimah',
                'kelas' => '11MM',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2007-11-25',
                'alamat' => 'Jl. Gatot Subroto No. 30, Surabaya',
                'nama_orang_tua' => 'Ali Azzahra',
                'telepon_orang_tua' => '081234567893',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(27),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'nis' => 'SMK005',
                'nisn' => '4234567894',
                'nama_lengkap' => 'Ibrahim Khalil',
                'nama_panggilan' => 'Ibrahim',
                'kelas' => '12RPL',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2006-02-14',
                'alamat' => 'Jl. Kuningan No. 20, Surabaya',
                'nama_orang_tua' => 'Umar Khalil',
                'telepon_orang_tua' => '081234567894',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(26),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];

        DB::table('siswa_smk')->insert($students);
    }

    private function seedSMKVocationalSkills(): void
    {
        $vocationalSkills = [
            [
                'nama_kejuruan' => 'Teknik Komputer dan Jaringan',
                'deskripsi' => 'Program keahlian di bidang teknologi komputer dan jaringan',
                'instruktur' => 'Guru SMK 1',
                'jadwal' => 'Senin - Jumat, 08:00 - 15:00',
                'lokasi' => 'Lab Komputer',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'nama_kejuruan' => 'Multimedia',
                'deskripsi' => 'Program keahlian di bidang multimedia dan desain grafis',
                'instruktur' => 'Guru SMK 2',
                'jadwal' => 'Senin - Jumat, 08:00 - 15:00',
                'lokasi' => 'Lab Multimedia',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'nama_kejuruan' => 'Rekayasa Perangkat Lunak',
                'deskripsi' => 'Program keahlian di bidang pengembangan perangkat lunak',
                'instruktur' => 'Guru SMK 1',
                'jadwal' => 'Senin - Jumat, 08:00 - 15:00',
                'lokasi' => 'Lab RPL',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];

        DB::table('kejuruan_smk')->insert($vocationalSkills);
    }

    private function seedSMKStudentPrograms(): void
    {
        $programs = [
            [
                'nama_program' => 'Program Magang Industri',
                'deskripsi' => 'Program magang untuk memberikan pengalaman kerja langsung di industri',
                'tanggal_mulai' => '2024-08-01',
                'tanggal_selesai' => '2024-12-31',
                'penanggung_jawab' => 'Guru SMK 1',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'nama_program' => 'Program Sertifikasi Kompetensi',
                'deskripsi' => 'Program untuk mendapatkan sertifikat kompetensi sesuai bidang keahlian',
                'tanggal_mulai' => '2024-09-01',
                'tanggal_selesai' => '2025-01-31',
                'penanggung_jawab' => 'Guru SMK 2',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
        ];

        DB::table('program_kesiswaan_smk')->insert($programs);
    }
}

