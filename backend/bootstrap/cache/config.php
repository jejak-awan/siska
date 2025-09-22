<?php return array (
  'queue' => 
  array (
    'default' => 'database',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => false,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'default',
        'suffix' => NULL,
        'region' => 'us-east-1',
        'after_commit' => false,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
        'after_commit' => false,
      ),
    ),
    'batching' => 
    array (
      'database' => 'backend',
      'table' => 'job_batches',
    ),
    'failed' => 
    array (
      'driver' => 'database-uuids',
      'database' => 'backend',
      'table' => 'failed_jobs',
    ),
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'reverb' => 
      array (
        'driver' => 'reverb',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
          'host' => NULL,
          'port' => 443,
          'scheme' => 'https',
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
          'cluster' => NULL,
          'host' => 'api-mt1.pusher.com',
          'port' => 443,
          'scheme' => 'https',
          'encrypted' => true,
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'ably' => 
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => '/opt/kesiswaan/siska/backend/storage/app',
        'throw' => false,
        'report' => false,
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => '/opt/kesiswaan/siska/backend/storage/app/public',
        'url' => 'http://localhost:8000/storage',
        'visibility' => 'public',
        'throw' => false,
        'report' => false,
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
        'endpoint' => NULL,
        'use_path_style_endpoint' => false,
        'throw' => false,
        'report' => false,
      ),
    ),
    'links' => 
    array (
      '/opt/kesiswaan/siska/backend/public/storage' => '/opt/kesiswaan/siska/backend/storage/app/public',
    ),
  ),
  'app' => 
  array (
    'name' => 'SISKA Core',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://localhost:8000',
    'frontend_url' => 'http://localhost:3000',
    'asset_url' => NULL,
    'timezone' => 'Asia/Jakarta',
    'locale' => 'id',
    'fallback_locale' => 'en',
    'faker_locale' => 'id_ID',
    'cipher' => 'AES-256-CBC',
    'key' => '',
    'previous_keys' => 
    array (
    ),
    'maintenance' => 
    array (
      'driver' => 'file',
      'store' => 'database',
    ),
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Concurrency\\ConcurrencyServiceProvider',
      6 => 'Illuminate\\Cookie\\CookieServiceProvider',
      7 => 'Illuminate\\Database\\DatabaseServiceProvider',
      8 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      9 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      10 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      11 => 'Illuminate\\Hashing\\HashServiceProvider',
      12 => 'Illuminate\\Mail\\MailServiceProvider',
      13 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      14 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      15 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      16 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      17 => 'Illuminate\\Queue\\QueueServiceProvider',
      18 => 'Illuminate\\Redis\\RedisServiceProvider',
      19 => 'Illuminate\\Session\\SessionServiceProvider',
      20 => 'Illuminate\\Translation\\TranslationServiceProvider',
      21 => 'Illuminate\\Validation\\ValidationServiceProvider',
      22 => 'Illuminate\\View\\ViewServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Concurrency' => 'Illuminate\\Support\\Facades\\Concurrency',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Context' => 'Illuminate\\Support\\Facades\\Context',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'Date' => 'Illuminate\\Support\\Facades\\Date',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Js' => 'Illuminate\\Support\\Js',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Number' => 'Illuminate\\Support\\Number',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Process' => 'Illuminate\\Support\\Facades\\Process',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'RateLimiter' => 'Illuminate\\Support\\Facades\\RateLimiter',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schedule' => 'Illuminate\\Support\\Facades\\Schedule',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Uri' => 'Illuminate\\Support\\Uri',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Vite' => 'Illuminate\\Support\\Facades\\Vite',
    ),
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => '12',
      'verify' => true,
    ),
    'argon' => 
    array (
      'memory' => 65536,
      'threads' => 1,
      'time' => 4,
      'verify' => true,
    ),
    'rehash_on_login' => true,
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'sanctum' => 
      array (
        'driver' => 'sanctum',
        'provider' => NULL,
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
      1 => 'sanctum/csrf-cookie',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'cache' => 
  array (
    'default' => 'database',
    'stores' => 
    array (
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'cache',
        'lock_connection' => NULL,
        'lock_table' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => '/opt/kesiswaan/siska/backend/storage/framework/cache/data',
        'lock_path' => '/opt/kesiswaan/siska/backend/storage/framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
      'octane' => 
      array (
        'driver' => 'octane',
      ),
    ),
    'prefix' => '',
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => '/opt/kesiswaan/siska/backend/resources/views',
    ),
    'compiled' => '/opt/kesiswaan/siska/backend/storage/framework/views',
  ),
  'services' => 
  array (
    'postmark' => 
    array (
      'token' => NULL,
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
    'resend' => 
    array (
      'key' => NULL,
    ),
    'slack' => 
    array (
      'notifications' => 
      array (
        'bot_user_oauth_token' => NULL,
        'channel' => NULL,
      ),
    ),
  ),
  'concurrency' => 
  array (
    'default' => 'process',
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'deprecations' => 
    array (
      'channel' => NULL,
      'trace' => false,
    ),
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => '/opt/kesiswaan/siska/backend/storage/logs/laravel.log',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => '/opt/kesiswaan/siska/backend/storage/logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
        'replace_placeholders' => true,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
          'connectionString' => 'tls://:',
        ),
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
        'facility' => 8,
        'replace_placeholders' => true,
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => '/opt/kesiswaan/siska/backend/storage/logs/laravel.log',
      ),
    ),
  ),
  'session' => 
  array (
    'driver' => 'database',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => '/opt/kesiswaan/siska/backend/storage/framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'siska_core_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => 'lax',
    'partitioned' => false,
  ),
  'mail' => 
  array (
    'default' => 'log',
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'smtp',
        'scheme' => NULL,
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '2525',
        'username' => NULL,
        'password' => NULL,
        'timeout' => NULL,
        'local_domain' => 'localhost',
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'resend' => 
      array (
        'transport' => 'resend',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs -i',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
      'failover' => 
      array (
        'transport' => 'failover',
        'mailers' => 
        array (
          0 => 'smtp',
          1 => 'log',
        ),
      ),
      'roundrobin' => 
      array (
        'transport' => 'roundrobin',
        'mailers' => 
        array (
          0 => 'ses',
          1 => 'postmark',
        ),
      ),
    ),
    'from' => 
    array (
      'address' => 'hello@example.com',
      'name' => 'SISKA Core',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => '/opt/kesiswaan/siska/backend/resources/views/vendor/mail',
      ),
    ),
  ),
  'database' => 
  array (
    'default' => 'backend',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => '/opt/kesiswaan/siska/backend/database/database.sqlite',
        'prefix' => '',
        'foreign_key_constraints' => true,
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'forge',
        'username' => 'siska_user',
        'password' => 'siska_password',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'mariadb' => 
      array (
        'driver' => 'mariadb',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'laravel',
        'username' => 'siska_user',
        'password' => 'siska_password',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'forge',
        'username' => 'siska_user',
        'password' => 'siska_password',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'search_path' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'forge',
        'username' => 'siska_user',
        'password' => 'siska_password',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
      'backend' => 
      array (
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'siska_backend',
        'username' => 'siska_user',
        'password' => 'siska_password',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'public' => 
      array (
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'siska_public',
        'username' => 'siska_user',
        'password' => 'siska_password',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'sd' => 
      array (
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'siska_sd',
        'username' => 'siska_user',
        'password' => 'siska_password',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'smp' => 
      array (
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'siska_smp',
        'username' => 'siska_user',
        'password' => 'siska_password',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'sma' => 
      array (
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'siska_sma',
        'username' => 'siska_user',
        'password' => 'siska_password',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'smk' => 
      array (
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'siska_smk',
        'username' => 'siska_user',
        'password' => 'siska_password',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'phpredis',
      'options' => 
      array (
        'cluster' => 'redis',
        'prefix' => 'siska_core_database_',
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
      ),
    ),
  ),
  'sanctum' => 
  array (
    'stateful' => 
    array (
      0 => 'localhost',
      1 => 'localhost:3000',
      2 => '127.0.0.1',
      3 => '127.0.0.1:8000',
      4 => '::1',
      5 => 'localhost:8000',
    ),
    'guard' => 
    array (
      0 => 'web',
    ),
    'expiration' => NULL,
    'token_prefix' => '',
    'middleware' => 
    array (
      'authenticate_session' => 'Laravel\\Sanctum\\Http\\Middleware\\AuthenticateSession',
      'encrypt_cookies' => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
      'validate_csrf_token' => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
    ),
  ),
  'siska' => 
  array (
    'version' => '1.0.0',
    'license_key' => '',
    'installation_id' => '',
    'sekolah_id' => '',
    'active_jenjang' => '',
    'multi_jenjang' => false,
    'jenjang' => 
    array (
      'sd' => 
      array (
        'name' => 'Sekolah Dasar',
        'short_name' => 'SD',
        'levels' => 
        array (
          0 => '1',
          1 => '2',
          2 => '3',
          3 => '4',
          4 => '5',
          5 => '6',
        ),
        'age_range' => 
        array (
          0 => 6,
          1 => 12,
        ),
        'default_modules' => 
        array (
          0 => 'presensi',
          1 => 'kredit_poin',
          2 => 'penilaian_karakter',
        ),
        'character_aspects' => 
        array (
          0 => 'jujur',
          1 => 'disiplin',
          2 => 'tanggung_jawab',
          3 => 'santun',
        ),
        'credit_categories' => 
        array (
          0 => 'disiplin',
          1 => 'kerapihan',
          2 => 'kerjasama',
          3 => 'tanggung_jawab',
        ),
      ),
      'smp' => 
      array (
        'name' => 'Sekolah Menengah Pertama',
        'short_name' => 'SMP',
        'levels' => 
        array (
          0 => '7',
          1 => '8',
          2 => '9',
        ),
        'age_range' => 
        array (
          0 => 12,
          1 => 15,
        ),
        'default_modules' => 
        array (
          0 => 'presensi',
          1 => 'kredit_poin',
          2 => 'penilaian_karakter',
          3 => 'ekstrakurikuler',
        ),
        'character_aspects' => 
        array (
          0 => 'jujur',
          1 => 'disiplin',
          2 => 'tanggung_jawab',
          3 => 'santun',
          4 => 'peduli',
          5 => 'percaya_diri',
        ),
        'credit_categories' => 
        array (
          0 => 'disiplin',
          1 => 'kerapihan',
          2 => 'kerjasama',
          3 => 'tanggung_jawab',
          4 => 'kepemimpinan',
        ),
      ),
      'sma' => 
      array (
        'name' => 'Sekolah Menengah Atas',
        'short_name' => 'SMA',
        'levels' => 
        array (
          0 => 'X',
          1 => 'XI',
          2 => 'XII',
        ),
        'age_range' => 
        array (
          0 => 15,
          1 => 18,
        ),
        'default_modules' => 
        array (
          0 => 'presensi',
          1 => 'kredit_poin',
          2 => 'penilaian_karakter',
          3 => 'ekstrakurikuler',
          4 => 'osis',
        ),
        'character_aspects' => 
        array (
          0 => 'jujur',
          1 => 'disiplin',
          2 => 'tanggung_jawab',
          3 => 'santun',
          4 => 'peduli',
          5 => 'percaya_diri',
          6 => 'kreatif',
          7 => 'mandiri',
        ),
        'credit_categories' => 
        array (
          0 => 'disiplin',
          1 => 'kerapihan',
          2 => 'kerjasama',
          3 => 'tanggung_jawab',
          4 => 'kepemimpinan',
          5 => 'kreativitas',
        ),
      ),
      'smk' => 
      array (
        'name' => 'Sekolah Menengah Kejuruan',
        'short_name' => 'SMK',
        'levels' => 
        array (
          0 => 'X',
          1 => 'XI',
          2 => 'XII',
        ),
        'age_range' => 
        array (
          0 => 15,
          1 => 18,
        ),
        'default_modules' => 
        array (
          0 => 'presensi',
          1 => 'kredit_poin',
          2 => 'penilaian_karakter',
          3 => 'ekstrakurikuler',
          4 => 'osis',
          5 => 'kejuruan',
        ),
        'character_aspects' => 
        array (
          0 => 'jujur',
          1 => 'disiplin',
          2 => 'tanggung_jawab',
          3 => 'santun',
          4 => 'peduli',
          5 => 'percaya_diri',
          6 => 'kreatif',
          7 => 'mandiri',
          8 => 'kerja_sama',
        ),
        'credit_categories' => 
        array (
          0 => 'disiplin',
          1 => 'kerapihan',
          2 => 'kerjasama',
          3 => 'tanggung_jawab',
          4 => 'kepemimpinan',
          5 => 'kreativitas',
          6 => 'kejuruan',
        ),
      ),
    ),
    'modules' => 
    array (
      'presensi' => 
      array (
        'name' => 'Sistem Presensi',
        'description' => 'Sistem presensi siswa dengan QR code',
        'required' => true,
        'features' => 
        array (
          0 => 'qr_code',
          1 => 'notifikasi',
          2 => 'laporan',
        ),
      ),
      'kredit_poin' => 
      array (
        'name' => 'Sistem Kredit Poin',
        'description' => 'Sistem penilaian perilaku dengan kredit poin',
        'required' => true,
        'features' => 
        array (
          0 => 'penilaian',
          1 => 'kategori',
          2 => 'riwayat',
        ),
      ),
      'penilaian_karakter' => 
      array (
        'name' => 'Penilaian Karakter',
        'description' => 'Sistem penilaian karakter siswa',
        'required' => true,
        'features' => 
        array (
          0 => 'asesmen',
          1 => 'indikator',
          2 => 'progress',
        ),
      ),
      'ekstrakurikuler' => 
      array (
        'name' => 'Ekstrakurikuler',
        'description' => 'Manajemen kegiatan ekstrakurikuler',
        'required' => false,
        'features' => 
        array (
          0 => 'kegiatan',
          1 => 'keanggotaan',
          2 => 'jadwal',
        ),
      ),
      'osis' => 
      array (
        'name' => 'OSIS',
        'description' => 'Manajemen organisasi siswa',
        'required' => false,
        'features' => 
        array (
          0 => 'organisasi',
          1 => 'kepengurusan',
          2 => 'kegiatan',
        ),
      ),
      'kejuruan' => 
      array (
        'name' => 'Kejuruan',
        'description' => 'Sistem khusus untuk SMK',
        'required' => false,
        'features' => 
        array (
          0 => 'kompetensi',
          1 => 'sertifikasi',
          2 => 'magang',
        ),
      ),
    ),
    'public_content' => 
    array (
      'news' => 
      array (
        'categories' => 
        array (
          0 => 'berita',
          1 => 'pengumuman',
          2 => 'artikel',
          3 => 'agenda',
        ),
        'max_file_size' => 10240,
        'allowed_file_types' => 
        array (
          0 => 'jpg',
          1 => 'jpeg',
          2 => 'png',
          3 => 'pdf',
          4 => 'doc',
          5 => 'docx',
        ),
      ),
      'programs' => 
      array (
        'categories' => 
        array (
          0 => 'akademik',
          1 => 'non_akademik',
          2 => 'organisasi',
          3 => 'kejuruan',
          4 => 'karakter',
        ),
        'statuses' => 
        array (
          0 => 'upcoming',
          1 => 'ongoing',
          2 => 'completed',
          3 => 'cancelled',
        ),
      ),
      'activities' => 
      array (
        'statuses' => 
        array (
          0 => 'upcoming',
          1 => 'ongoing',
          2 => 'completed',
          3 => 'cancelled',
        ),
        'max_gallery_images' => 10,
      ),
    ),
    'whatsapp' => 
    array (
      'api_url' => '',
      'api_token' => '',
      'phone_number' => '',
      'templates' => 
      array (
        'presensi' => 'Presensi siswa {nama} pada {tanggal} dengan status {status}',
        'kredit_poin' => 'Kredit poin siswa {nama}: {poin} untuk {aspek}',
        'pengumuman' => 'Pengumuman: {judul} - {konten}',
      ),
    ),
    'upload' => 
    array (
      'max_file_size' => '10240',
      'allowed_file_types' => 
      array (
        0 => 'jpg',
        1 => 'jpeg',
        2 => 'png',
        3 => 'pdf',
        4 => 'doc',
        5 => 'docx',
        6 => 'xls',
        7 => 'xlsx',
      ),
      'storage_disk' => 'public',
      'image_quality' => 80,
      'image_resize' => 
      array (
        'thumbnail' => 
        array (
          0 => 150,
          1 => 150,
        ),
        'medium' => 
        array (
          0 => 500,
          1 => 500,
        ),
        'large' => 
        array (
          0 => 1200,
          1 => 1200,
        ),
      ),
    ),
    'cache' => 
    array (
      'ttl' => 
      array (
        'license_info' => 3600,
        'profil_sekolah' => 1800,
        'public_content' => 300,
        'jenjang_config' => 3600,
      ),
      'tags' => 
      array (
        0 => 'license',
        1 => 'sekolah',
        2 => 'public',
        3 => 'jenjang',
      ),
    ),
    'security' => 
    array (
      'password_min_length' => 8,
      'password_require_special' => true,
      'session_timeout' => 120,
      'max_login_attempts' => 5,
      'lockout_duration' => 15,
      'require_2fa' => false,
    ),
    'backup' => 
    array (
      'enabled' => true,
      'schedule' => 'daily',
      'retention_days' => 30,
      'compress' => true,
      'encrypt' => false,
      'storage_disk' => 'local',
      'include_files' => true,
    ),
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
);
