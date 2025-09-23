<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * User Seeder untuk SISKA Backend System
 * 
 * @package Database\Seeders
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'username' => 'admin',
            'email' => 'admin@siska.local',
            'password' => Hash::make('admin123'),
            'role_type' => 'admin',
            'status' => 'aktif',
            'profile_data' => json_encode([
                'nama_lengkap' => 'Administrator SISKA',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Contoh No. 123, Jakarta',
            ]),
        ]);

        // Create guru user
        User::create([
            'username' => 'guru',
            'email' => 'guru@siska.local',
            'password' => Hash::make('guru123'),
            'role_type' => 'guru',
            'status' => 'aktif',
            'profile_data' => json_encode([
                'nama_lengkap' => 'Guru Contoh',
                'telepon' => '081234567891',
                'alamat' => 'Jl. Guru No. 456, Jakarta',
                'mata_pelajaran' => 'Matematika',
            ]),
        ]);

        // Create siswa user
        User::create([
            'username' => 'siswa',
            'email' => 'siswa@siska.local',
            'password' => Hash::make('siswa123'),
            'role_type' => 'siswa',
            'status' => 'aktif',
            'profile_data' => json_encode([
                'nama_lengkap' => 'Siswa Contoh',
                'telepon' => '081234567892',
                'alamat' => 'Jl. Siswa No. 789, Jakarta',
                'kelas' => 'X-A',
                'nis' => '2024001',
            ]),
        ]);

        $this->command->info('User seeder berhasil dijalankan!');
        $this->command->info('Admin: admin / admin123');
        $this->command->info('Guru: guru / guru123');
        $this->command->info('Siswa: siswa / siswa123');
    }
}
