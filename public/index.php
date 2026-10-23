<?php
/* Public entry (document root = public/). Delegates to the master front controller. */
if (PHP_SAPI === 'cli-server') {
    $f = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($f)) return false; // let php -S serve static assets
}
require dirname(__DIR__) . '/index.php';
