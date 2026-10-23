<?php
/**
 * Master front controller / bootstrap.
 * Works with Composer (vendor/autoload.php) or without it (fallback PSR-4 autoloader below).
 * public/index.php and the root .htaccess both funnel requests here.
 */
declare(strict_types=1);

define('BASE_PATH', __DIR__);
define('PUBLIC_PATH', BASE_PATH . '/public');

if (is_file(BASE_PATH . '/vendor/autoload.php')) {
    require BASE_PATH . '/vendor/autoload.php';
} else {
    spl_autoload_register(function (string $class): void {
        if (strncmp($class, 'App\\', 4) !== 0) return;
        $file = BASE_PATH . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
        if (is_file($file)) require $file;
    });
    require_once BASE_PATH . '/app/Helpers/helpers.php';
}

// Built-in dev server (php -S localhost:8000 index.php): serve real files from /public directly.
if (PHP_SAPI === 'cli-server') {
    $path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
    $file = realpath(PUBLIC_PATH . $path);
    if ($path !== '/' && $file && str_starts_with($file, realpath(PUBLIC_PATH)) && is_file($file)) {
        $types = ['css'=>'text/css','js'=>'application/javascript','svg'=>'image/svg+xml','png'=>'image/png','jpg'=>'image/jpeg','webp'=>'image/webp','ico'=>'image/x-icon','mp4'=>'video/mp4','webm'=>'video/webm','json'=>'application/json'];
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (isset($types[$ext])) header('Content-Type: ' . $types[$ext]);
        header('Content-Length: ' . filesize($file));
        readfile($file);
        return true;
    }
}

\App\Core\App::boot(BASE_PATH)->run();
