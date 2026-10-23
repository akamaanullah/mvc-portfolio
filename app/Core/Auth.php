<?php
namespace App\Core;

use App\Models\UserModel;

class Auth
{
    private const SESSION_TIMEOUT = 7200; // 2 hours idle timeout
    private const MAX_ATTEMPTS = 5;
    private const LOCKOUT_TIME = 900; // 15 minutes lockout

    public static function start(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            if (!headers_sent()) {
                $params = session_get_cookie_params();
                session_set_cookie_params([
                    'lifetime' => $params['lifetime'],
                    'path' => $params['path'] ?? '/',
                    'domain' => $params['domain'] ?? '',
                    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);
                session_start();
            } else {
                @session_start();
            }
        }
    }

    public static function check(): bool
    {
        self::start();
        if (empty($_SESSION['admin_user_id'])) {
            return false;
        }

        // Check idle timeout
        $lastActivity = $_SESSION['admin_last_activity'] ?? 0;
        if (time() - $lastActivity > self::SESSION_TIMEOUT) {
            self::logout();
            return false;
        }

        $_SESSION['admin_last_activity'] = time();
        return true;
    }

    public static function user(): ?array
    {
        if (!self::check()) return null;
        return [
            'id' => $_SESSION['admin_user_id'],
            'name' => $_SESSION['admin_user_name'] ?? 'Admin',
            'email' => $_SESSION['admin_user_email'] ?? '',
            'role' => $_SESSION['admin_user_role'] ?? 'admin',
            'avatar' => $_SESSION['admin_user_avatar'] ?? 'media/profile-poster.jpg',
        ];
    }

    public static function id(): ?int
    {
        return self::check() ? (int)$_SESSION['admin_user_id'] : null;
    }

    public static function attempt(string $email, string $password): array
    {
        self::start();
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

        // Check Rate Limiting
        if (self::isRateLimited($ip)) {
            return ['success' => false, 'error' => 'Too many failed login attempts. Please wait 15 minutes before trying again.'];
        }

        $user = UserModel::findByEmail($email);
        if (!$user) {
            self::recordFailedAttempt($ip);
            return ['success' => false, 'error' => 'Invalid email or password.'];
        }

        if (!UserModel::verifyPassword($password, $user['password'])) {
            self::recordFailedAttempt($ip);
            return ['success' => false, 'error' => 'Invalid email or password.'];
        }

        // Successful authentication
        self::clearFailedAttempts($ip);
        if (!headers_sent()) {
            session_regenerate_id(true);
        }

        $_SESSION['admin_user_id'] = (int)$user['id'];
        $_SESSION['admin_user_name'] = $user['name'];
        $_SESSION['admin_user_email'] = $user['email'];
        $_SESSION['admin_user_role'] = $user['role'] ?? 'admin';
        $_SESSION['admin_user_avatar'] = $user['avatar'] ?: 'media/profile-poster.jpg';
        $_SESSION['admin_last_activity'] = time();

        UserModel::updateLastLogin((int)$user['id']);
        Logger::info('Admin user logged in', ['email' => $user['email'], 'ip' => $ip]);

        return ['success' => true, 'user' => $user];
    }

    public static function logout(): void
    {
        self::start();
        $email = $_SESSION['admin_user_email'] ?? null;
        unset(
            $_SESSION['admin_user_id'],
            $_SESSION['admin_user_name'],
            $_SESSION['admin_user_email'],
            $_SESSION['admin_user_role'],
            $_SESSION['admin_user_avatar'],
            $_SESSION['admin_last_activity']
        );
        if (!headers_sent()) {
            session_regenerate_id(true);
        }
        if ($email) {
            Logger::info('Admin user logged out', ['email' => $email]);
        }
    }

    private static function isRateLimited(string $ip): bool
    {
        $key = 'login_attempts_' . md5($ip);
        $attempts = $_SESSION[$key] ?? [];
        $cutoff = time() - self::LOCKOUT_TIME;
        $validAttempts = array_filter($attempts, fn($t) => $t > $cutoff);
        $_SESSION[$key] = $validAttempts;
        return count($validAttempts) >= self::MAX_ATTEMPTS;
    }

    private static function recordFailedAttempt(string $ip): void
    {
        $key = 'login_attempts_' . md5($ip);
        if (!isset($_SESSION[$key])) $_SESSION[$key] = [];
        $_SESSION[$key][] = time();
    }

    private static function clearFailedAttempts(string $ip): void
    {
        $key = 'login_attempts_' . md5($ip);
        unset($_SESSION[$key]);
    }
}
