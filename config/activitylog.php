<?php
// config/activitylog.php
return [
    'enabled' => true,
    // path full ke folder log activity
    'path' => storage_path('logs/activity'),
    // exclude input fields yang tidak boleh di-log
    'exclude_fields' => [
        'password',
        'password_confirmation',
        'current_password',
        '_token',
        'token',
        'api_token',
    ],
    // berapa minggu disimpan (cleanup command gunakan nilai ini)
    'retention_weeks' => 12,
    // apakah week dimulai hari Senin atau Minggu (Carbon constants optionally)
    'week_start' => 'sunday', // 'monday' atau 'sunday' (penjelasan: digunakan untuk nama file)
    // pattern file prefix
    'file_prefix' => 'activity-',
];
