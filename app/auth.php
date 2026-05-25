<?php
declare(strict_types=1);

/**
 * Session-based auth for the CMS admin.
 */
function auth_user(): ?array
{
    if (empty($_SESSION['admin_id'])) return null;
    static $cache = null;
    if ($cache && (int)$cache['id'] === (int)$_SESSION['admin_id']) return $cache;
    $cache = User::find((int)$_SESSION['admin_id']);
    return $cache;
}

function auth_check(): bool
{
    return auth_user() !== null;
}

function auth_login(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['admin_id'] = (int)$user['id'];
    $_SESSION['admin_email'] = $user['email'];
}

function auth_logout(): void
{
    unset($_SESSION['admin_id'], $_SESSION['admin_email']);
    session_regenerate_id(true);
}

/** Middleware: redirect to login if not authenticated. */
function auth_require(): void
{
    if (!auth_check()) {
        // Remember intended destination
        $_SESSION['_intended'] = current_path();
        redirect('/admin/login');
    }
}
