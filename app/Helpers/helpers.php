<?php
/* Global helpers: env(), config(), base_url(), asset_url(), e()/sanitize(), view(), csrf_token(). */

if (!defined('PUBLIC_PATH')) {
    define('PUBLIC_PATH', (defined('BASE_PATH') ? BASE_PATH : dirname(__DIR__, 2)) . '/public');
}

if (!function_exists('env')) {
    function env(string $key, $default = null) {
        static $vars = null;
        if ($vars === null) {
            $vars = [];
            $file = (defined('BASE_PATH') ? BASE_PATH : dirname(__DIR__, 2)) . '/.env';
            if (is_file($file)) {
                foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                    $line = trim($line);
                    if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) continue;
                    [$k, $v] = array_map('trim', explode('=', $line, 2));
                    $vars[$k] = trim($v, "\"'");
                }
            }
        }
        $v = getenv($key);
        if ($v !== false) return $v;
        return array_key_exists($key, $vars) ? $vars[$key] : $default;
    }
}

function config(string $key, $default = null) {
    static $cache = [];
    [$file, $item] = array_pad(explode('.', $key, 2), 2, null);
    if (!isset($cache[$file])) {
        $path = BASE_PATH . "/config/{$file}.php";
        $cache[$file] = is_file($path) ? require $path : [];
    }
    return $item === null ? $cache[$file] : ($cache[$file][$item] ?? $default);
}

/**
 * Retrieve dynamic configuration setting from database 'settings' table.
 * Caches all settings in static memory on first call for zero query overhead.
 */
if (!function_exists('setting')) {
    function setting(string $key, $default = null, bool $refresh = false) {
        static $settings = null;
        if ($settings === null || $refresh) {
            try {
                $db = \App\Core\Database::connection();
                $stmt = $db->query("SELECT `key`, `value` FROM settings");
                $settings = $stmt ? ($stmt->fetchAll(PDO::FETCH_KEY_PAIR) ?: []) : [];
            } catch (\Throwable $e) {
                $settings = [];
            }
        }
        if (array_key_exists($key, $settings) && $settings[$key] !== null && $settings[$key] !== '') {
            return $settings[$key];
        }
        return $default;
    }
}

/**
 * Save or update a dynamic configuration setting in database.
 */
if (!function_exists('save_setting')) {
    function save_setting(string $key, $value): bool {
        try {
            $db = \App\Core\Database::connection();
            $stmt = $db->prepare("INSERT INTO settings (`key`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)");
            $ok = $stmt->execute([$key, (string)$value]);
            setting($key, null, true);
            return $ok;
        } catch (\Throwable $e) {
            \App\Core\Logger::error("Failed to save setting [{$key}]: " . $e->getMessage());
            return false;
        }
    }
}

/** Base path of the app, e.g. "" at the web root or "/web3d" in a XAMPP sub-folder. */
function base_path_url(): string {
    static $base = null;
    if ($base !== null) return $base;
    $url = config('app.url');
    if ($url) return $base = rtrim((string) parse_url($url, PHP_URL_PATH), '/');
    if (PHP_SAPI === 'cli-server') return $base = '';
    $dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
    $dir = preg_replace('#/public$#', '', rtrim($dir, '/'));
    return $base = ($dir === '/' ? '' : $dir);
}

function base_url(string $path = '/'): string {
    $path = '/' . ltrim($path, '/');
    $b = base_path_url();
    return $b === '' ? $path : ($path === '/' ? $b . '/' : $b . $path);
}

function asset_url(string $path): string {
    return base_url('/' . ltrim($path, '/'));
}

/** Get client IP address resolving Cloudflare, proxies, or remote address. */
if (!function_exists('client_ip')) {
    function client_ip(): string {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP']
            ?? $_SERVER['HTTP_X_REAL_IP']
            ?? null;
        if (!$ip && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $parts = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($parts[0]);
        }
        return $ip ?: ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');
    }
}

function e($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Trim + strip tags + drop control characters for user input. */
function sanitize($value): string {
    $value = is_string($value) ? $value : '';
    $value = strip_tags($value);
    return trim(preg_replace('/[^\P{C}\n\t]+/u', '', $value) ?? '');
}

function view_path(string $view): string {
    return BASE_PATH . '/views/' . ltrim($view, '/');
}

/** Render a view (views/<name>.php) with data and return the HTML. */
function view(string $name, array $data = []): string {
    $file = view_path(str_ends_with($name, '.php') ? $name : $name . '.php');
    if (!is_file($file)) throw new RuntimeException("View not found: {$name}");
    extract($data, EXTR_SKIP);
    ob_start();
    try { require $file; } catch (Throwable $t) { ob_end_clean(); throw $t; }
    return ob_get_clean();
}

function csrf_token(): string {
    if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
        session_start();
    }
    if (empty($_SESSION['_token'])) $_SESSION['_token'] = bin2hex(random_bytes(32));
    return $_SESSION['_token'] ?? '';
}

function csrf_verify(?string $token): bool {
    if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
        session_start();
    }
    return is_string($token) && !empty($_SESSION['_token']) && hash_equals($_SESSION['_token'], $token);
}

function redirect(string $path, int $code = 302): void {
    header('Location: ' . (preg_match('#^https?://#', $path) ? $path : base_url($path)), true, $code);
    exit;
}
