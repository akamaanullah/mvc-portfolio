<?php
namespace App\Core;

use PDO;

/** Lazy PDO singleton built from config/database.php (.env). */
class Database
{
    private static ?PDO $pdo = null;

    public static function enabled(): bool { return (bool) config('database.enabled'); }

    public static function connection(): PDO
    {
        if (self::$pdo) return self::$pdo;
        $c = config('database');
        $dsn = sprintf('%s:host=%s;port=%d;dbname=%s;charset=%s', $c['driver'], $c['host'], $c['port'], $c['database'], $c['charset']);
        return self::$pdo = new PDO($dsn, $c['username'], $c['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
}
