<?php
namespace App\Core;

/**
 * Base model. For now every model serves the hard-coded page data in static::data().
 * With DB_ENABLED=true and rows in the table, the same methods read from MySQL instead.
 */
abstract class Model
{
    protected static string $table = '';

    /** Hard-coded rows (the content currently shown on the pages). */
    abstract protected static function data(): array;

    public static function all(): array
    {
        if (static::$table && Database::enabled()) {
            try {
                $rows = Database::connection()->query('SELECT * FROM `' . static::$table . '`')->fetchAll();
                if ($rows) return $rows;
            } catch (\Throwable $e) {
                Logger::warning('DB read failed, using static data: ' . $e->getMessage());
            }
        }
        return static::data();
    }

    public static function find(string $slug): ?array
    {
        foreach (static::all() as $row) if (($row['slug'] ?? null) === $slug) return $row;
        return null;
    }
}
