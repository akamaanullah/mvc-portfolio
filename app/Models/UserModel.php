<?php
namespace App\Models;

use App\Core\Database;
use App\Core\Logger;
use App\Core\Model;

class UserModel extends Model
{
    protected static string $table = 'users';

    /** No hardcoded credentials. Users strictly reside in the database. */
    protected static function data(): array
    {
        return [];
    }

    /**
     * Find a user by email using parameterized PDO query.
     */
    public static function findByEmail(string $email): ?array
    {
        $email = trim(strtolower($email));
        if ($email === '' || !Database::enabled()) {
            return null;
        }

        try {
            $stmt = Database::connection()->prepare('SELECT id, name, email, password, role, avatar FROM `users` WHERE LOWER(email) = :email LIMIT 1');
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
            return $user ?: null;
        } catch (\Throwable $e) {
            Logger::error('User findByEmail query error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Find a user by ID using parameterized PDO query.
     */
    public static function findById(int $id): ?array
    {
        if ($id <= 0 || !Database::enabled()) {
            return null;
        }

        try {
            $stmt = Database::connection()->prepare('SELECT id, name, email, role, avatar, created_at, updated_at FROM `users` WHERE id = :id LIMIT 1');
            $stmt->execute(['id' => $id]);
            $user = $stmt->fetch();
            return $user ?: null;
        } catch (\Throwable $e) {
            Logger::error('User findById query error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Verify plain-text password against bcrypt hash.
     */
    public static function verifyPassword(string $password, string $hash): bool
    {
        if ($password === '' || $hash === '') {
            return false;
        }
        return password_verify($password, $hash);
    }

    /**
     * Generate secure bcrypt hash (cost 12).
     */
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * Securely update user password in database.
     */
    public static function updatePassword(int $id, string $plainPassword): bool
    {
        if ($id <= 0 || strlen($plainPassword) < 6 || !Database::enabled()) {
            return false;
        }

        $hash = self::hashPassword($plainPassword);
        try {
            $stmt = Database::connection()->prepare('UPDATE `users` SET password = :password, updated_at = NOW() WHERE id = :id');
            return $stmt->execute(['password' => $hash, 'id' => $id]);
        } catch (\Throwable $e) {
            Logger::error('Password update failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update user last login timestamp.
     */
    public static function updateLastLogin(int $id): void
    {
        if ($id <= 0 || !Database::enabled()) {
            return;
        }

        try {
            $stmt = Database::connection()->prepare('UPDATE `users` SET updated_at = NOW() WHERE id = :id');
            $stmt->execute(['id' => $id]);
        } catch (\Throwable $e) {
            Logger::warning('Update last login failed: ' . $e->getMessage());
        }
    }
}
