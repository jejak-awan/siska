<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SMK Module Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for the SMK (Sekolah Menengah Kejuruan) module.
    | This includes database connections, features, and module-specific settings.
    |
    */

    'module' => [
        'name' => 'SMK',
        'display_name' => 'Sekolah Menengah Kejuruan',
        'description' => 'Manajemen siswa SMK dengan kejuruan dan program kesiswaan',
        'version' => '1.0.0',
        'database' => 'siska_smk',
    ],

    'features' => [
        'siswa' => [
            'enabled' => true,
            'description' => 'Manajemen data siswa SMK',
            'permissions' => ['create', 'read', 'update', 'delete']
        ],
        'presensi' => [
            'enabled' => true,
            'description' => 'Sistem presensi siswa SMK',
            'permissions' => ['create', 'read', 'update', 'delete', 'bulk_create']
        ],
        'kejuruan' => [
            'enabled' => true,
            'description' => 'Sistem kejuruan siswa SMK',
            'permissions' => ['create', 'read', 'update', 'delete', 'manage_students']
        ],
        'program_kesiswaan' => [
            'enabled' => true,
            'description' => 'Program kesiswaan khusus SMK',
            'permissions' => ['create', 'read', 'update', 'delete', 'manage_participants']
        ]
    ],

    'database' => [
        'connection' => 'smk',
        'tables' => [
            'users' => 'users_smk',
            'siswa' => 'siswa_smk',
            'presensi' => 'presensi_smk',
            'kejuruan' => 'kejuruan_smk',
            'kejuruan_siswa' => 'kejuruan_siswa_smk',
            'program_kesiswaan' => 'program_kesiswaan_smk',
            'program_peserta' => 'program_peserta_smk'
        ]
    ],

    'validation' => [
        'siswa' => [
            'nis' => 'required|string|max:20|unique:siswa_smk,nis',
            'nisn' => 'required|string|max:20|unique:siswa_smk,nisn',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'agama' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'nomor_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:users_smk,email',
            'kelas' => 'required|string|max:10',
            'jurusan' => 'required|string|max:50',
            'tahun_masuk' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'status' => 'required|in:aktif,nonaktif,lulus,pindah',
        ],
        'presensi' => [
            'siswa_id' => 'required|exists:siswa_smk,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string|max:255',
        ],
        'kejuruan' => [
            'nama_kejuruan' => 'required|string|max:255|unique:kejuruan_smk,nama_kejuruan',
            'kode_kejuruan' => 'required|string|max:10|unique:kejuruan_smk,kode_kejuruan',
            'deskripsi' => 'nullable|string',
            'pembina' => 'required|string|max:255',
            'jadwal' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'kuota_maksimal' => 'required|integer|min:1|max:100',
            'status' => 'required|in:aktif,nonaktif,ditutup',
        ],
        'program_kesiswaan' => [
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'penanggung_jawab' => 'required|string|max:255',
            'status' => 'required|in:aktif,selesai,ditunda,dibatalkan',
        ],
    ],

    'permissions' => [
        'siswa' => [
            'view_any_siswa' => 'Melihat daftar semua siswa SMK',
            'view_siswa' => 'Melihat detail siswa SMK',
            'create_siswa' => 'Menambah siswa SMK baru',
            'update_siswa' => 'Mengubah data siswa SMK',
            'delete_siswa' => 'Menghapus siswa SMK',
            'export_siswa' => 'Mengekspor data siswa SMK',
            'import_siswa' => 'Mengimpor data siswa SMK',
        ],
        'presensi' => [
            'view_any_presensi' => 'Melihat daftar semua presensi siswa SMK',
            'view_presensi' => 'Melihat detail presensi siswa SMK',
            'create_presensi' => 'Menambah data presensi siswa SMK',
            'update_presensi' => 'Mengubah data presensi siswa SMK',
            'delete_presensi' => 'Menghapus data presensi siswa SMK',
            'bulk_create_presensi' => 'Membuat presensi massal siswa SMK',
        ],
        'kejuruan' => [
            'view_any_kejuruan' => 'Melihat daftar semua kejuruan SMK',
            'view_kejuruan' => 'Melihat detail kejuruan SMK',
            'create_kejuruan' => 'Menambah kejuruan SMK baru',
            'update_kejuruan' => 'Mengubah data kejuruan SMK',
            'delete_kejuruan' => 'Menghapus kejuruan SMK',
            'manage_kejuruan_students' => 'Mengelola siswa dalam kejuruan SMK',
        ],
        'program_kesiswaan' => [
            'view_any_program_kesiswaan' => 'Melihat daftar semua program kesiswaan SMK',
            'view_program_kesiswaan' => 'Melihat detail program kesiswaan SMK',
            'create_program_kesiswaan' => 'Menambah program kesiswaan SMK baru',
            'update_program_kesiswaan' => 'Mengubah data program kesiswaan SMK',
            'delete_program_kesiswaan' => 'Menghapus program kesiswaan SMK',
            'manage_program_kesiswaan_participants' => 'Mengelola peserta program kesiswaan SMK',
        ],
    ],

    'settings' => [
        'presensi_auto_fill' => true,
        'kejuruan_max_students' => 50,
        'program_max_participants' => 100,
    ],
];

