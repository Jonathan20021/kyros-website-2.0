<?php
declare(strict_types=1);

/**
 * Tiny file-based rate limiter, IP scoped.
 * Records a JSON list of recent timestamps under storage/cache/rl_<key>_<iphash>.json
 */
class RateLimit
{
    public static function hit(string $key, int $max, int $windowSeconds): bool
    {
        $dir = base_path('storage/cache');
        if (!is_dir($dir)) @mkdir($dir, 0775, true);

        $file = $dir . '/rl_' . $key . '_' . sha1(client_ip()) . '.json';
        $now  = time();

        $hits = is_file($file) ? (json_decode((string) file_get_contents($file), true) ?: []) : [];
        $hits = array_values(array_filter($hits, fn($t) => $now - (int) $t < $windowSeconds));

        if (count($hits) >= $max) {
            return false;
        }

        $hits[] = $now;
        @file_put_contents($file, json_encode($hits));
        return true;
    }
}
