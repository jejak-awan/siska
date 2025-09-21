<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SISKA Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi khusus untuk sistem SISKA
    |
    */

    'version' => env('SISKA_VERSION', '1.0.0'),
    'license_key' => env('SISKA_LICENSE_KEY'),
    'installation_id' => env('SISKA_INSTALLATION_ID'),
    'school_id' => env('SISKA_SCHOOL_ID'),
    'active_jenjang' => env('SISKA_ACTIVE_JENJANG'),
    'multi_jenjang' => env('SISKA_MULTI_JENJANG', false),

    /*
    |--------------------------------------------------------------------------
    | Jenjang Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk setiap jenjang pendidikan
    |
    */

    'jenjang' => [
        'sd' => [
            'name' => 'Sekolah Dasar',
            'short_name' => 'SD',
            'levels' => ['1', '2', '3', '4', '5', '6'],
            'age_range' => [6, 12],
            'default_modules' => ['presensi', 'kredit_poin', 'penilaian_karakter'],
            'character_aspects' => ['jujur', 'disiplin', 'tanggung_jawab', 'santun'],
            'credit_categories' => ['disiplin', 'kerapihan', 'kerjasama', 'tanggung_jawab'],
        ],
        'smp' => [
            'name' => 'Sekolah Menengah Pertama',
            'short_name' => 'SMP',
            'levels' => ['7', '8', '9'],
            'age_range' => [12, 15],
            'default_modules' => ['presensi', 'kredit_poin', 'penilaian_karakter', 'ekstrakurikuler'],
            'character_aspects' => ['jujur', 'disiplin', 'tanggung_jawab', 'santun', 'peduli', 'percaya_diri'],
            'credit_categories' => ['disiplin', 'kerapihan', 'kerjasama', 'tanggung_jawab', 'kepemimpinan'],
        ],
        'sma' => [
            'name' => 'Sekolah Menengah Atas',
            'short_name' => 'SMA',
            'levels' => ['X', 'XI', 'XII'],
            'age_range' => [15, 18],
            'default_modules' => ['presensi', 'kredit_poin', 'penilaian_karakter', 'ekstrakurikuler', 'osis'],
            'character_aspects' => ['jujur', 'disiplin', 'tanggung_jawab', 'santun', 'peduli', 'percaya_diri', 'kreatif', 'mandiri'],
            'credit_categories' => ['disiplin', 'kerapihan', 'kerjasama', 'tanggung_jawab', 'kepemimpinan', 'kreativitas'],
        ],
        'smk' => [
            'name' => 'Sekolah Menengah Kejuruan',
            'short_name' => 'SMK',
            'levels' => ['X', 'XI', 'XII'],
            'age_range' => [15, 18],
            'default_modules' => ['presensi', 'kredit_poin', 'penilaian_karakter', 'ekstrakurikuler', 'osis', 'kejuruan'],
            'character_aspects' => ['jujur', 'disiplin', 'tanggung_jawab', 'santun', 'peduli', 'percaya_diri', 'kreatif', 'mandiri', 'kerja_sama'],
            'credit_categories' => ['disiplin', 'kerapihan', 'kerjasama', 'tanggung_jawab', 'kepemimpinan', 'kreativitas', 'kejuruan'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Module Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk setiap modul
    |
    */

    'modules' => [
        'presensi' => [
            'name' => 'Sistem Presensi',
            'description' => 'Sistem presensi siswa dengan QR code',
            'required' => true,
            'features' => ['qr_code', 'notifikasi', 'laporan'],
        ],
        'kredit_poin' => [
            'name' => 'Sistem Kredit Poin',
            'description' => 'Sistem penilaian perilaku dengan kredit poin',
            'required' => true,
            'features' => ['penilaian', 'kategori', 'riwayat'],
        ],
        'penilaian_karakter' => [
            'name' => 'Penilaian Karakter',
            'description' => 'Sistem penilaian karakter siswa',
            'required' => true,
            'features' => ['asesmen', 'indikator', 'progress'],
        ],
        'ekstrakurikuler' => [
            'name' => 'Ekstrakurikuler',
            'description' => 'Manajemen kegiatan ekstrakurikuler',
            'required' => false,
            'features' => ['kegiatan', 'keanggotaan', 'jadwal'],
        ],
        'osis' => [
            'name' => 'OSIS',
            'description' => 'Manajemen organisasi siswa',
            'required' => false,
            'features' => ['organisasi', 'kepengurusan', 'kegiatan'],
        ],
        'kejuruan' => [
            'name' => 'Kejuruan',
            'description' => 'Sistem khusus untuk SMK',
            'required' => false,
            'features' => ['kompetensi', 'sertifikasi', 'magang'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Content Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk konten publik
    |
    */

    'public_content' => [
        'news' => [
            'categories' => ['berita', 'pengumuman', 'artikel', 'agenda'],
            'max_file_size' => 10240, // KB
            'allowed_file_types' => ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'],
        ],
        'programs' => [
            'categories' => ['akademik', 'non_akademik', 'organisasi', 'kejuruan', 'karakter'],
            'statuses' => ['upcoming', 'ongoing', 'completed', 'cancelled'],
        ],
        'activities' => [
            'statuses' => ['upcoming', 'ongoing', 'completed', 'cancelled'],
            'max_gallery_images' => 10,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Integration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk integrasi WhatsApp
    |
    */

    'whatsapp' => [
        'api_url' => env('WHATSAPP_API_URL'),
        'api_token' => env('WHATSAPP_API_TOKEN'),
        'phone_number' => env('WHATSAPP_PHONE_NUMBER'),
        'templates' => [
            'presensi' => 'Presensi siswa {nama} pada {tanggal} dengan status {status}',
            'kredit_poin' => 'Kredit poin siswa {nama}: {poin} untuk {aspek}',
            'pengumuman' => 'Pengumuman: {judul} - {konten}',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk upload file
    |
    */

    'upload' => [
        'max_file_size' => env('MAX_FILE_SIZE', 10240), // KB
        'allowed_file_types' => explode(',', env('ALLOWED_FILE_TYPES', 'jpg,jpeg,png,pdf,doc,docx,xls,xlsx')),
        'storage_disk' => 'public',
        'image_quality' => 80,
        'image_resize' => [
            'thumbnail' => [150, 150],
            'medium' => [500, 500],
            'large' => [1200, 1200],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk caching
    |
    */

    'cache' => [
        'ttl' => [
            'license_info' => 3600, // 1 hour
            'school_profile' => 1800, // 30 minutes
            'public_content' => 300, // 5 minutes
            'jenjang_config' => 3600, // 1 hour
        ],
        'tags' => [
            'license',
            'school',
            'public',
            'jenjang',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk keamanan
    |
    */

    'security' => [
        'password_min_length' => 8,
        'password_require_special' => true,
        'session_timeout' => 120, // minutes
        'max_login_attempts' => 5,
        'lockout_duration' => 15, // minutes
        'require_2fa' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Backup Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk backup
    |
    */

    'backup' => [
        'enabled' => true,
        'schedule' => 'daily',
        'retention_days' => 30,
        'compress' => true,
        'encrypt' => false,
        'storage_disk' => 'local',
        'include_files' => true,
    ],
];
