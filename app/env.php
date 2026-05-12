<?php
declare(strict_types=1);

/**
 * Tiny .env loader (no Composer). Parses KEY=VALUE lines, supports
 * "quoted values" with spaces, ignores comments and blank lines.
 */
function load_env(string $path): void
{
    if (!is_readable($path)) return;

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        if (!str_contains($line, '=')) continue;

        [$key, $value] = array_map('trim', explode('=', $line, 2));
        if ($key === '') continue;

        // Strip surrounding quotes
        if (preg_match('/^"(.*)"$/', $value, $m) || preg_match("/^'(.*)'$/", $value, $m)) {
            $value = $m[1];
        }

        $_ENV[$key] = $value;
        putenv("$key=$value");
    }
}

function env(string $key, $default = null)
{
    $val = $_ENV[$key] ?? getenv($key);
    if ($val === false || $val === null || $val === '') return $default;

    return match (strtolower((string) $val)) {
        'true', '(true)'   => true,
        'false', '(false)' => false,
        'null', '(null)'   => null,
        default            => $val,
    };
}
