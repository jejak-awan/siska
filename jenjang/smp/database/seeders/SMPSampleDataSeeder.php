<?php

namespace Jenjang\SMP\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SMPSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed SMP Users
        $this->seedSMPUsers();
        
        // Seed SMP Students
        $this->seedSMPStudents();
        
        // Seed SMP Extracurriculars
        $this->seedSMPExtracurriculars();
        
        // Seed SMP Student Programs
        $this->seedSMPStudentPrograms();
    }

    private function seedSMPUsers(): void
    {
        $users = [
            [
                'name' => 'Admin SMP',
                'email' => 'admin@smp2bandung.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'admin',
                'jenjang' => 'SMP',
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'name' => 'Guru SMP 1',
                'email' => 'guru1@smp2bandung.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'guru',
                'jenjang' => 'SMP',
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'name' => 'Guru SMP 2',
                'email' => 'guru2@smp2bandung.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'guru',
                'jenjang' => 'SMP',
                'is_active' => true,
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];

        DB::table('users_smp')->insert($users);
    }

    private function seedSMPStudents(): void
    {
        $students = [
            [
                'nis' => 'SMP001',
                'nisn' => '2234567890',
                'nama_lengkap' => 'Rizki Pratama',
                'nama_panggilan' => 'Rizki',
                'kelas' => '7A',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2011-03-15',
                'alamat' => 'Jl. Asia Afrika No. 10, Bandung',
                'nama_orang_tua' => 'Budi Pratama',
                'telepon_orang_tua' => '081234567890',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'nis' => 'SMP002',
                'nisn' => '2234567891',
                'nama_lengkap' => 'Sari Dewi',
                'nama_panggilan' => 'Sari',
                'kelas' => '7A',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2011-05-20',
                'alamat' => 'Jl. Sudirman No. 25, Bandung',
                'nama_orang_tua' => 'Ahmad Dewi',
                'telepon_orang_tua' => '081234567891',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(29),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'nis' => 'SMP003',
                'nisn' => '2234567892',
                'nama_lengkap' => 'Fauzi Rahman',
                'nama_panggilan' => 'Fauzi',
                'kelas' => '8A',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2010-08-10',
                'alamat' => 'Jl. Thamrin No. 15, Bandung',
                'nama_orang_tua' => 'Hasan Rahman',
                'telepon_orang_tua' => '081234567892',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(28),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'nis' => 'SMP004',
                'nisn' => '2234567893',
                'nama_lengkap' => 'Maya Sari',
                'nama_panggilan' => 'Maya',
                'kelas' => '8A',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2010-11-25',
                'alamat' => 'Jl. Gatot Subroto No. 30, Bandung',
                'nama_orang_tua' => 'Ali Sari',
                'telepon_orang_tua' => '081234567893',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(27),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'nis' => 'SMP005',
                'nisn' => '2234567894',
                'nama_lengkap' => 'Ibrahim Khalil',
                'nama_panggilan' => 'Ibrahim',
                'kelas' => '9A',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2009-02-14',
                'alamat' => 'Jl. Kuningan No. 20, Bandung',
                'nama_orang_tua' => 'Umar Khalil',
                'telepon_orang_tua' => '081234567894',
                'status' => 'aktif',
                'foto_url' => null,
                'created_at' => Carbon::now()->subDays(26),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];

        DB::table('siswa_smp')->insert($students);
    }

    private function seedSMPExtracurriculars(): void
    {
        $extracurriculars = [
            [
                'nama_ekstrakurikuler' => 'Pramuka',
                'deskripsi' => 'Kegiatan kepramukaan untuk melatih kedisiplinan dan kepemimpinan',
                'pembina' => 'Guru SMP 1',
                'jadwal' => 'Sabtu, 08:00 - 10:00',
                'lokasi' => 'Lapangan Sekolah',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'nama_ekstrakurikuler' => 'Basket',
                'deskripsi' => 'Kegiatan basket untuk mengembangkan kemampuan olahraga',
                'pembina' => 'Guru SMP 2',
                'jadwal' => 'Rabu, 14:00 - 16:00',
                'lokasi' => 'Lapangan Basket',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'nama_ekstrakurikuler' => 'Teater',
                'deskripsi' => 'Kegiatan teater untuk mengembangkan bakat seni peran',
                'pembina' => 'Guru SMP 1',
                'jadwal' => 'Kamis, 15:00 - 17:00',
                'lokasi' => 'Aula Sekolah',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];

        DB::table('ekstrakurikuler_smp')->insert($extracurriculars);
    }

    private function seedSMPStudentPrograms(): void
    {
        $programs = [
            [
                'nama_program' => 'Program Literasi Digital',
                'deskripsi' => 'Program untuk meningkatkan kemampuan literasi digital siswa',
                'tanggal_mulai' => '2024-08-01',
                'tanggal_selesai' => '2024-12-31',
                'penanggung_jawab' => 'Guru SMP 1',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'nama_program' => 'Program Anti Bullying',
                'deskripsi' => 'Program untuk mencegah dan mengatasi bullying di sekolah',
                'tanggal_mulai' => '2024-09-01',
                'tanggal_selesai' => '2025-01-31',
                'penanggung_jawab' => 'Guru SMP 2',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
        ];

        DB::table('program_kesiswaan_smp')->insert($programs);
    }
}

