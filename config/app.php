<?php
return [
    'name'  => env('APP_NAME', 'Amaanullah'),
    'env'   => env('APP_ENV', 'production'),
    'debug' => filter_var(env('APP_DEBUG', false), FILTER_VALIDATE_BOOLEAN),
    'url'   => rtrim((string) env('APP_URL', ''), '/'),
    'log_level' => env('LOG_LEVEL', 'info'),
    'timezone'  => env('APP_TIMEZONE', 'Asia/Karachi'),
];
