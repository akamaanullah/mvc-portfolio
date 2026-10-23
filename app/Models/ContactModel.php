<?php
namespace App\Models;

use App\Core\Database;
use App\Core\Logger;
use App\Core\Model;

class ContactModel extends Model
{
    protected static string $table = 'contacts';
    public const FIELDS = ['name', 'email', 'phone', 'company', 'service', 'project_type', 'budget', 'timeline', 'preferred_contact', 'message', 'description'];

    protected static function data(): array { return []; }

    /** Store a contact request in MySQL when DB_ENABLED=true, otherwise in storage/logs/contacts.log (JSON lines). */
    public static function create(array $input): int
    {
        $row = [];
        foreach (self::FIELDS as $f) {
            $v = $input[$f] ?? '';
            $v = sanitize(is_array($v) ? implode(', ', $v) : $v);
            $row[$f] = function_exists('mb_substr') ? mb_substr($v, 0, 5000) : substr($v, 0, 5000);
        }
        $row['ip'] = $_SERVER['REMOTE_ADDR'] ?? null;
        $row['created_at'] = date('Y-m-d H:i:s');

        if (Database::enabled()) {
            try {
                $cols = array_keys($row);
                $sql = 'INSERT INTO contacts (`' . implode('`,`', $cols) . '`) VALUES (:' . implode(',:', $cols) . ')';
                $pdo = Database::connection();
                $pdo->prepare($sql)->execute($row);
                return (int)$pdo->lastInsertId();
            } catch (\Throwable $e) {
                Logger::error('Contact insert failed: ' . $e->getMessage());
            }
        }
        $ok = @file_put_contents(BASE_PATH . '/storage/logs/contacts.log', json_encode($row, JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND | LOCK_EX) !== false;
        Logger::info('Contact request stored', ['email' => $row['email']]);
        return $ok ? 1 : 0;
    }
}
