<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SMA Module Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for the SMA (Sekolah Menengah Atas) module.
    | This includes database connections, features, and module-specific settings.
    |
    */

    'module' => [
        'name' => 'SMA',
        'display_name' => 'Sekolah Menengah Atas',
        'description' => 'Manajemen siswa SMA dengan organisasi dan program kesiswaan',
        'version' => '1.0.0',
        'database' => 'siska_sma',
    ],

    'features' => [
        'siswa' => [
            'enabled' => true,
            'description' => 'Manajemen data siswa SMA',
            'permissions' => ['create', 'read', 'update', 'delete']
        ],
        'presensi' => [
            'enabled' => true,
            'description' => 'Sistem presensi siswa SMA',
            'permissions' => ['create', 'read', 'update', 'delete', 'bulk_create']
        ],
        'organisasi' => [
            'enabled' => true,
            'description' => 'Sistem organisasi siswa SMA',
            'permissions' => ['create', 'read', 'update', 'delete', 'manage_members']
        ],
        'program_kesiswaan' => [
            'enabled' => true,
            'description' => 'Program kesiswaan khusus SMA',
            'permissions' => ['create', 'read', 'update', 'delete', 'manage_participants']
        ]
    ],

    'database' => [
        'connection' => 'sma',
        'tables' => [
            'users' => 'users_sma',
            'siswa' => 'siswa_sma',
            'presensi' => 'presensi_sma',
            'organisasi' => 'organisasi_sma',
            'organisasi_anggota' => 'organisasi_anggota_sma',
            'program_kesiswaan' => 'program_kesiswaan_sma',
            'program_peserta' => 'program_peserta_sma'
        ]
    ],

    'validation' => [
        'siswa' => [
            'nis' => 'required|string|max:20|unique:siswa_sma,nis',
            'nisn' => 'required|string|max:20|unique:siswa_sma,nisn',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'agama' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'nomor_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:users_sma,email',
            'kelas' => 'required|string|max:10',
            'tahun_masuk' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'status' => 'required|in:aktif,nonaktif,lulus,pindah',
        ],
        'presensi' => [
            'siswa_id' => 'required|exists:siswa_sma,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string|max:255',
        ],
        'organisasi' => [
            'nama_organisasi' => 'required|string|max:255|unique:organisasi_sma,nama_organisasi',
            'deskripsi' => 'nullable|string',
            'pembina' => 'required|string|max:255',
            'ketua' => 'nullable|string|max:255',
            'wakil_ketua' => 'nullable|string|max:255',
            'sekretaris' => 'nullable|string|max:255',
            'bendahara' => 'nullable|string|max:255',
            'tanggal_berdiri' => 'required|date',
            'status' => 'required|in:aktif,nonaktif,dibubarkan',
        ],
        'program_kesiswaan' => [
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'penanggung_jawab' => 'required|string|max:255',
            'organisasi_id' => 'nullable|exists:organisasi_sma,id',
            'status' => 'required|in:aktif,selesai,ditunda,dibatalkan',
        ],
    ],

    'permissions' => [
        'siswa' => [
            'view_any_siswa' => 'Melihat daftar semua siswa SMA',
            'view_siswa' => 'Melihat detail siswa SMA',
            'create_siswa' => 'Menambah siswa SMA baru',
            'update_siswa' => 'Mengubah data siswa SMA',
            'delete_siswa' => 'Menghapus siswa SMA',
            'export_siswa' => 'Mengekspor data siswa SMA',
            'import_siswa' => 'Mengimpor data siswa SMA',
        ],
        'presensi' => [
            'view_any_presensi' => 'Melihat daftar semua presensi siswa SMA',
            'view_presensi' => 'Melihat detail presensi siswa SMA',
            'create_presensi' => 'Menambah data presensi siswa SMA',
            'update_presensi' => 'Mengubah data presensi siswa SMA',
            'delete_presensi' => 'Menghapus data presensi siswa SMA',
            'bulk_create_presensi' => 'Membuat presensi massal siswa SMA',
        ],
        'organisasi' => [
            'view_any_organisasi' => 'Melihat daftar semua organisasi SMA',
            'view_organisasi' => 'Melihat detail organisasi SMA',
            'create_organisasi' => 'Menambah organisasi SMA baru',
            'update_organisasi' => 'Mengubah data organisasi SMA',
            'delete_organisasi' => 'Menghapus organisasi SMA',
            'manage_organisasi_members' => 'Mengelola anggota organisasi SMA',
        ],
        'program_kesiswaan' => [
            'view_any_program_kesiswaan' => 'Melihat daftar semua program kesiswaan SMA',
            'view_program_kesiswaan' => 'Melihat detail program kesiswaan SMA',
            'create_program_kesiswaan' => 'Menambah program kesiswaan SMA baru',
            'update_program_kesiswaan' => 'Mengubah data program kesiswaan SMA',
            'delete_program_kesiswaan' => 'Menghapus program kesiswaan SMA',
            'manage_program_kesiswaan_participants' => 'Mengelola peserta program kesiswaan SMA',
        ],
    ],

    'settings' => [
        'presensi_auto_fill' => true,
        'organisasi_max_members' => 100,
        'program_max_participants' => 200,
    ],
];

