<?php
/* Usage: php bin/migrate.php  — runs database/schema.sql against the DB configured in .env */
define('BASE_PATH', dirname(__DIR__));
require BASE_PATH . '/app/Helpers/helpers.php';
spl_autoload_register(function ($c) { if (str_starts_with($c, 'App\\')) require BASE_PATH . '/app/' . str_replace('\\', '/', substr($c, 4)) . '.php'; });
try {
    $pdo = \App\Core\Database::connection();
    $sql = preg_replace('/^--.*$/m', '', file_get_contents(BASE_PATH . '/database/schema.sql'));
    foreach (array_filter(array_map('trim', explode(';', $sql))) as $stmt) $pdo->exec($stmt);
    echo "Migration complete.\n";
} catch (Throwable $e) {
    fwrite(STDERR, 'Migration failed: ' . $e->getMessage() . "\n");
    exit(1);
}
