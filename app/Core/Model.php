<?php
namespace App\Core;

/**
 * Base model. For now every model serves the hard-coded page data in static::data().
 * With DB_ENABLED=true and rows in the table, the same methods read from MySQL instead.
 */
abstract class Model
{
    protected static string $table = '';

    /** Default fallback when table is empty or database not enabled */
    protected static function data(): array
    {
        return [];
    }

    public static function all(string $orderBy = 'id DESC'): array
    {
        if (static::$table && Database::enabled()) {
            try {
                $cleanOrder = '';
                if ($orderBy && preg_match('/^[a-zA-Z0-9_,\s]+$/', $orderBy)) {
                    $cleanOrder = ' ORDER BY ' . $orderBy;
                }
                $sql = 'SELECT * FROM `' . static::$table . '`' . $cleanOrder;
                $rows = Database::connection()->query($sql)->fetchAll();
                if ($rows !== false) {
                    return $rows;
                }
            } catch (\Throwable $e) {
                Logger::warning('DB read failed, using static data: ' . $e->getMessage());
            }
        }
        return static::data();
    }

    public static function find(string $slug): ?array
    {
        if (static::$table && Database::enabled()) {
            try {
                $stmt = Database::connection()->prepare('SELECT * FROM `' . static::$table . '` WHERE `slug` = :slug LIMIT 1');
                $stmt->execute(['slug' => $slug]);
                $row = $stmt->fetch();
                return $row ?: null;
            } catch (\Throwable $e) {
                Logger::warning('DB find by slug failed: ' . $e->getMessage());
            }
        }
        foreach (static::data() as $row) {
            if (($row['slug'] ?? null) === $slug) return $row;
        }
        return null;
    }

    public static function findById(int|string $id): ?array
    {
        if (static::$table && Database::enabled()) {
            try {
                $stmt = Database::connection()->prepare('SELECT * FROM `' . static::$table . '` WHERE `id` = :id LIMIT 1');
                $stmt->execute(['id' => $id]);
                $row = $stmt->fetch();
                return $row ?: null;
            } catch (\Throwable $e) {
                Logger::warning('DB find by id failed: ' . $e->getMessage());
            }
        }
        foreach (static::data() as $row) {
            if ((string)($row['id'] ?? '') === (string)$id) return $row;
        }
        return null;
    }

    public static function where(string $column, mixed $value, string $orderBy = 'id DESC'): array
    {
        if (static::$table && Database::enabled()) {
            try {
                $cleanCol = preg_replace('/[^a-zA-Z0-9_]/', '', $column);
                $cleanOrder = '';
                if ($orderBy && preg_match('/^[a-zA-Z0-9_,\s]+$/', $orderBy)) {
                    $cleanOrder = ' ORDER BY ' . $orderBy;
                }
                $sql = 'SELECT * FROM `' . static::$table . '` WHERE `' . $cleanCol . '` = :val' . $cleanOrder;
                $stmt = Database::connection()->prepare($sql);
                $stmt->execute(['val' => $value]);
                $rows = $stmt->fetchAll();
                if ($rows !== false) {
                    return $rows;
                }
            } catch (\Throwable $e) {
                Logger::warning('DB where query failed: ' . $e->getMessage());
            }
        }
        return array_values(array_filter(static::data(), fn($r) => ($r[$column] ?? null) == $value));
    }

    public static function create(array $data): int
    {
        if (!static::$table || !Database::enabled()) {
            throw new \RuntimeException('Database is not enabled or table is not defined.');
        }

        $fields = array_keys($data);
        $escapedFields = array_map(fn($f) => '`' . preg_replace('/[^a-zA-Z0-9_]/', '', $f) . '`', $fields);
        $placeholders = array_map(fn($f) => ':' . preg_replace('/[^a-zA-Z0-9_]/', '', $f), $fields);

        $sql = sprintf(
            'INSERT INTO `%s` (%s) VALUES (%s)',
            static::$table,
            implode(', ', $escapedFields),
            implode(', ', $placeholders)
        );

        $params = [];
        foreach ($data as $k => $v) {
            $cleanKey = preg_replace('/[^a-zA-Z0-9_]/', '', $k);
            $params[$cleanKey] = $v;
        }

        $pdo = Database::connection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return (int) $pdo->lastInsertId();
    }

    public static function update(int|string $id, array $data): bool
    {
        if (!static::$table || !Database::enabled()) {
            throw new \RuntimeException('Database is not enabled or table is not defined.');
        }

        if (empty($data)) {
            return false;
        }

        $setPieces = [];
        $params = ['__id' => $id];

        foreach ($data as $k => $v) {
            $cleanKey = preg_replace('/[^a-zA-Z0-9_]/', '', $k);
            $setPieces[] = '`' . $cleanKey . '` = :' . $cleanKey;
            $params[$cleanKey] = $v;
        }

        $sql = sprintf('UPDATE `%s` SET %s WHERE `id` = :__id', static::$table, implode(', ', $setPieces));
        $stmt = Database::connection()->prepare($sql);
        return $stmt->execute($params);
    }

    public static function delete(int|string $id): bool
    {
        if (!static::$table || !Database::enabled()) {
            throw new \RuntimeException('Database is not enabled or table is not defined.');
        }

        $stmt = Database::connection()->prepare('DELETE FROM `' . static::$table . '` WHERE `id` = :id');
        return $stmt->execute(['id' => $id]);
    }

    public static function count(string $where = '', array $params = []): int
    {
        if (!static::$table || !Database::enabled()) {
            return count(static::data());
        }

        try {
            $sql = 'SELECT COUNT(*) FROM `' . static::$table . '`' . ($where ? ' WHERE ' . $where : '');
            $stmt = Database::connection()->prepare($sql);
            $stmt->execute($params);
            return (int) $stmt->fetchColumn();
        } catch (\Throwable $e) {
            Logger::warning('DB count query failed: ' . $e->getMessage());
            return 0;
        }
    }
}
