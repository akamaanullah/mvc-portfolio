<?php
namespace App\Models;

use App\Core\Model;

class ServiceModel extends Model
{
    protected static string $table = 'services';

    public static function find(string $slug): ?array
    {
        // 1. Exact match
        $row = parent::find($slug);
        if ($row) {
            return $row;
        }

        // 2. Dynamic DB match
        if (static::$table && \App\Core\Database::enabled()) {
            try {
                $db = \App\Core\Database::connection();
                $stmt = $db->prepare('SELECT * FROM `' . static::$table . '` WHERE `slug` LIKE :prefix ORDER BY `id` ASC LIMIT 1');
                $stmt->execute(['prefix' => $slug . '-%']);
                $matched = $stmt->fetch();
                if ($matched) {
                    return $matched;
                }

                $stmt = $db->prepare('SELECT * FROM `' . static::$table . '` WHERE `slug` LIKE :contains ORDER BY `id` ASC LIMIT 1');
                $stmt->execute(['contains' => '%' . $slug . '%']);
                $matched = $stmt->fetch();
                if ($matched) {
                    return $matched;
                }
            } catch (\Throwable $e) {}
        }

        return null;
    }
}
