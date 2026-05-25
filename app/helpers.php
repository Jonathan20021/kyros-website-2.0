<?php
declare(strict_types=1);

/* ──────────────────────────────────────────────
   General helpers
   ────────────────────────────────────────────── */

function base_path(string $path = ''): string
{
    return rtrim(dirname(__DIR__), '/\\') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, '/\\') : '');
}

/**
 * Returns the base URL of the current installation, auto-detecting
 * localhost so APP_URL can stay pinned to the canonical production URL
 * without breaking local dev.
 */
function base_url(): string
{
    static $cached;
    if ($cached !== null) return $cached;

    $configured = rtrim((string) env('APP_URL', ''), '/');
    $host = $_SERVER['HTTP_HOST'] ?? '';

    $isLocal = $host && (
        str_starts_with($host, 'localhost')
        || str_starts_with($host, '127.')
        || str_starts_with($host, '192.168.')
        || str_starts_with($host, '10.')
        || str_ends_with($host, '.local')
        || str_ends_with($host, '.test')
    );

    if ($isLocal) {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $scriptBase = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        $cached = $scheme . '://' . $host . $scriptBase;
    } else {
        $cached = $configured ?: ((!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $host);
    }
    return $cached;
}

function url(string $path = ''): string
{
    return base_url() . '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    $local = base_path('assets/' . ltrim($path, '/'));
    $version = is_file($local) ? '?v=' . filemtime($local) : '';
    return base_url() . '/assets/' . ltrim($path, '/') . $version;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function current_path(): string
{
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
    // Strip script base ("/kyros") so internal routes are clean
    $scriptBase = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    if ($scriptBase && str_starts_with($uri, $scriptBase)) {
        $uri = substr($uri, strlen($scriptBase));
    }
    return '/' . ltrim($uri, '/');
}

function is_active(string $path): bool
{
    $current = rtrim(current_path(), '/') ?: '/';
    $target  = rtrim($path, '/') ?: '/';
    if ($target === '/') return $current === '/';
    return str_starts_with($current, $target);
}

function nav_link_class(string $path): string
{
    return is_active($path)
        ? 'text-white bg-white/10'
        : 'text-gray-300 hover:text-white hover:bg-white/5';
}

function redirect(string $to): never
{
    header('Location: ' . url(ltrim($to, '/')));
    exit;
}

function back(): never
{
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? url('/')));
    exit;
}

function abort(int $code, string $message = ''): never
{
    http_response_code($code);
    render_view('404', ['code' => $code, 'message' => $message]);
    exit;
}

function flash(string $key, $value = null)
{
    if (func_num_args() === 1) {
        $val = $_SESSION['_flash'][$key] ?? null;
        unset($_SESSION['_flash'][$key]);
        return $val;
    }
    $_SESSION['_flash'][$key] = $value;
}

function old(string $key, $default = '')
{
    return $_SESSION['_old'][$key] ?? $default;
}

function set_old(array $values): void
{
    $_SESSION['_old'] = $values;
}

function clear_old(): void
{
    unset($_SESSION['_old']);
}

function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function csrf_check(string $token): bool
{
    return !empty($_SESSION['_csrf']) && hash_equals($_SESSION['_csrf'], $token);
}

function client_ip(): string
{
    foreach (['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'] as $k) {
        if (!empty($_SERVER[$k])) {
            $ip = explode(',', $_SERVER[$k])[0];
            return trim($ip);
        }
    }
    return '0.0.0.0';
}
