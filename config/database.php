<?php
return [
    'enabled'  => filter_var(env('DB_ENABLED', false), FILTER_VALIDATE_BOOLEAN),
    'driver'   => 'mysql',
    'host'     => env('DB_HOST', '127.0.0.1'),
    'port'     => (int) env('DB_PORT', 3306),
    'database' => env('DB_DATABASE', 'web3d'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'charset'  => env('DB_CHARSET', 'utf8mb4'),
];
