<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PresensiSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed SD Presensi
        $this->seedSDPresensi();
        
        // Seed SMP Presensi
        $this->seedSMPPresensi();
        
        // Seed SMA Presensi
        $this->seedSMAPresensi();
        
        // Seed SMK Presensi
        $this->seedSMKPresensi();
    }

    private function seedSDPresensi(): void
    {
        $presensi = [];
        $students = DB::table('siswa_sd')->get();
        $dates = $this->generateDates(30); // Last 30 days

        foreach ($students as $student) {
            foreach ($dates as $date) {
                $status = $this->getRandomStatus();
                $presensi[] = [
                    'siswa_id' => $student->id,
                    'tanggal' => $date,
                    'status' => $status,
                    'keterangan' => $status === 'izin' ? 'Izin sakit' : ($status === 'sakit' ? 'Sakit demam' : null),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table('presensi_sd')->insert($presensi);
    }

    private function seedSMPPresensi(): void
    {
        $presensi = [];
        $students = DB::table('siswa_smp')->get();
        $dates = $this->generateDates(30); // Last 30 days

        foreach ($students as $student) {
            foreach ($dates as $date) {
                $status = $this->getRandomStatus();
                $presensi[] = [
                    'siswa_id' => $student->id,
                    'tanggal' => $date,
                    'status' => $status,
                    'keterangan' => $status === 'izin' ? 'Izin sakit' : ($status === 'sakit' ? 'Sakit demam' : null),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table('presensi_smp')->insert($presensi);
    }

    private function seedSMAPresensi(): void
    {
        $presensi = [];
        $students = DB::table('siswa_sma')->get();
        $dates = $this->generateDates(30); // Last 30 days

        foreach ($students as $student) {
            foreach ($dates as $date) {
                $status = $this->getRandomStatus();
                $presensi[] = [
                    'siswa_id' => $student->id,
                    'tanggal' => $date,
                    'status' => $status,
                    'keterangan' => $status === 'izin' ? 'Izin sakit' : ($status === 'sakit' ? 'Sakit demam' : null),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table('presensi_sma')->insert($presensi);
    }

    private function seedSMKPresensi(): void
    {
        $presensi = [];
        $students = DB::table('siswa_smk')->get();
        $dates = $this->generateDates(30); // Last 30 days

        foreach ($students as $student) {
            foreach ($dates as $date) {
                $status = $this->getRandomStatus();
                $presensi[] = [
                    'siswa_id' => $student->id,
                    'tanggal' => $date,
                    'status' => $status,
                    'keterangan' => $status === 'izin' ? 'Izin sakit' : ($status === 'sakit' ? 'Sakit demam' : null),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table('presensi_smk')->insert($presensi);
    }

    private function generateDates($days): array
    {
        $dates = [];
        for ($i = $days; $i >= 1; $i--) {
            $date = Carbon::now()->subDays($i);
            // Skip weekends
            if ($date->dayOfWeek !== Carbon::SATURDAY && $date->dayOfWeek !== Carbon::SUNDAY) {
                $dates[] = $date->format('Y-m-d');
            }
        }
        return $dates;
    }

    private function getRandomStatus(): string
    {
        $statuses = ['hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'izin', 'sakit', 'alpha'];
        return $statuses[array_rand($statuses)];
    }
}

