<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SD Module Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for the SD (Sekolah Dasar) module.
    | This includes database connections, features, and module-specific settings.
    |
    */

    'module' => [
        'name' => 'SD',
        'display_name' => 'Sekolah Dasar',
        'description' => 'Manajemen siswa SD dengan fokus pada karakter dasar, kebersihan, dan kedisiplinan',
        'version' => '1.0.0',
        'database' => 'siska_sd',
    ],

    'features' => [
        'siswa' => [
            'enabled' => true,
            'description' => 'Manajemen data siswa SD',
            'permissions' => ['create', 'read', 'update', 'delete']
        ],
        'presensi' => [
            'enabled' => true,
            'description' => 'Sistem presensi siswa SD',
            'permissions' => ['create', 'read', 'update', 'delete', 'bulk_create']
        ],
        'ekstrakurikuler' => [
            'enabled' => true,
            'description' => 'Manajemen ekstrakurikuler SD',
            'permissions' => ['create', 'read', 'update', 'delete', 'manage_students']
        ],
        'program_kesiswaan' => [
            'enabled' => true,
            'description' => 'Program kesiswaan khusus SD',
            'permissions' => ['create', 'read', 'update', 'delete', 'manage_participants']
        ]
    ],

    'database' => [
        'connection' => 'sd',
        'tables' => [
            'users' => 'users_sd',
            'siswa' => 'siswa_sd',
            'presensi' => 'presensi_sd',
            'ekstrakurikuler' => 'ekstrakurikuler_sd',
            'ekstrakurikuler_siswa' => 'ekstrakurikuler_siswa_sd',
            'program_kesiswaan' => 'program_kesiswaan_sd',
            'program_peserta' => 'program_peserta_sd'
        ]
    ],

    'validation' => [
        'siswa' => [
            'nis' => 'required|string|max:20|unique:siswa_sd,nis',
            'nisn' => 'required|string|max:20|unique:siswa_sd,nisn',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:10',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string|max:500',
            'telepon' => 'nullable|string|max:20',
            'nama_orang_tua' => 'nullable|string|max:255',
            'telepon_orang_tua' => 'nullable|string|max:20'
        ],
        'presensi' => [
            'id_siswa' => 'required|exists:siswa_sd,id',
            'tanggal' => 'required|date',
            'status_presensi' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string|max:255'
        ],
        'kredit_poin' => [
            'id_siswa' => 'required|exists:siswa_sd,id',
            'kategori' => 'required|in:positif,negatif',
            'poin' => 'required|integer|min:1|max:100',
            'deskripsi' => 'required|string|max:500',
            'tanggal' => 'required|date',
            'pemberi_poin_id' => 'required|exists:users_sd,id',
            'semester' => 'required|integer|min:1|max:2',
            'tahun_akademik' => 'required|string|max:10'
        ]
    ],

    'permissions' => [
        'admin' => ['*'],
        'guru' => ['siswa.read', 'presensi.*', 'kredit_poin.*', 'program_kesiswaan.read'],
        'wali_kelas' => ['siswa.read', 'presensi.*', 'kredit_poin.*', 'program_kesiswaan.read'],
        'siswa' => ['siswa.read_own', 'presensi.read_own', 'kredit_poin.read_own']
    ],

    'settings' => [
        'max_siswa_per_kelas' => 30,
        'max_poin_per_semester' => 100,
        'auto_presensi_timeout' => 30, // minutes
        'enable_kredit_poin' => true,
        'enable_penilaian_karakter' => true,
        'default_semester' => 1,
        'default_tahun_akademik' => date('Y') . '/' . (date('Y') + 1)
    ]
];
