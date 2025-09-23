<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SMP Module Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for the SMP (Sekolah Menengah Pertama) module.
    | This includes database connections, features, and module-specific settings.
    |
    */

    'module' => [
        'name' => 'SMP',
        'display_name' => 'Sekolah Menengah Pertama',
        'description' => 'Manajemen siswa SMP dengan ekstrakurikuler dan program kesiswaan',
        'version' => '1.0.0',
        'database' => 'siska_smp',
    ],

    'features' => [
        'siswa' => [
            'enabled' => true,
            'description' => 'Manajemen data siswa SMP',
            'permissions' => ['create', 'read', 'update', 'delete']
        ],
        'presensi' => [
            'enabled' => true,
            'description' => 'Sistem presensi siswa SMP',
            'permissions' => ['create', 'read', 'update', 'delete', 'bulk_create']
        ],
        'ekstrakurikuler' => [
            'enabled' => true,
            'description' => 'Sistem ekstrakurikuler siswa SMP',
            'permissions' => ['create', 'read', 'update', 'delete', 'manage_students']
        ],
        'program_kesiswaan' => [
            'enabled' => true,
            'description' => 'Program kesiswaan khusus SMP',
            'permissions' => ['create', 'read', 'update', 'delete', 'manage_participants']
        ]
    ],

    'database' => [
        'connection' => 'smp',
        'tables' => [
            'users' => 'users_smp',
            'siswa' => 'siswa_smp',
            'presensi' => 'presensi_smp',
            'ekstrakurikuler' => 'ekstrakurikuler_smp',
            'ekstrakurikuler_siswa' => 'ekstrakurikuler_siswa_smp',
            'program_kesiswaan' => 'program_kesiswaan_smp',
            'program_peserta' => 'program_peserta_smp'
        ]
    ],

    'validation' => [
        'siswa' => [
            'nis' => 'required|string|max:20|unique:siswa_smp,nis',
            'nisn' => 'required|string|max:20|unique:siswa_smp,nisn',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'agama' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'nomor_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:users_smp,email',
            'kelas' => 'required|string|max:10',
            'tahun_masuk' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'status' => 'required|in:aktif,nonaktif,lulus,pindah',
        ],
        'presensi' => [
            'siswa_id' => 'required|exists:siswa_smp,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string|max:255',
        ],
        'ekstrakurikuler' => [
            'nama_ekstrakurikuler' => 'required|string|max:255|unique:ekstrakurikuler_smp,nama_ekstrakurikuler',
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
            'view_any_siswa' => 'Melihat daftar semua siswa SMP',
            'view_siswa' => 'Melihat detail siswa SMP',
            'create_siswa' => 'Menambah siswa SMP baru',
            'update_siswa' => 'Mengubah data siswa SMP',
            'delete_siswa' => 'Menghapus siswa SMP',
            'export_siswa' => 'Mengekspor data siswa SMP',
            'import_siswa' => 'Mengimpor data siswa SMP',
        ],
        'presensi' => [
            'view_any_presensi' => 'Melihat daftar semua presensi siswa SMP',
            'view_presensi' => 'Melihat detail presensi siswa SMP',
            'create_presensi' => 'Menambah data presensi siswa SMP',
            'update_presensi' => 'Mengubah data presensi siswa SMP',
            'delete_presensi' => 'Menghapus data presensi siswa SMP',
            'bulk_create_presensi' => 'Membuat presensi massal siswa SMP',
        ],
        'ekstrakurikuler' => [
            'view_any_ekstrakurikuler' => 'Melihat daftar semua ekstrakurikuler SMP',
            'view_ekstrakurikuler' => 'Melihat detail ekstrakurikuler SMP',
            'create_ekstrakurikuler' => 'Menambah ekstrakurikuler SMP baru',
            'update_ekstrakurikuler' => 'Mengubah data ekstrakurikuler SMP',
            'delete_ekstrakurikuler' => 'Menghapus ekstrakurikuler SMP',
            'manage_ekstrakurikuler_students' => 'Mengelola siswa dalam ekstrakurikuler SMP',
        ],
        'program_kesiswaan' => [
            'view_any_program_kesiswaan' => 'Melihat daftar semua program kesiswaan SMP',
            'view_program_kesiswaan' => 'Melihat detail program kesiswaan SMP',
            'create_program_kesiswaan' => 'Menambah program kesiswaan SMP baru',
            'update_program_kesiswaan' => 'Mengubah data program kesiswaan SMP',
            'delete_program_kesiswaan' => 'Menghapus program kesiswaan SMP',
            'manage_program_kesiswaan_participants' => 'Mengelola peserta program kesiswaan SMP',
        ],
    ],

    'settings' => [
        'presensi_auto_fill' => true,
        'ekstrakurikuler_max_students' => 50,
        'program_max_participants' => 100,
    ],
];