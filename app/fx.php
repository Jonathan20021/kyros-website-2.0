<?php
declare(strict_types=1);

/**
 * USD → DOP exchange rate.
 *
 * Cached to storage/cache/fx_usd_dop.json. The network call is best-effort with
 * a hard 3s timeout: the form must render instantly even if the API is slow or
 * down, so a stale cache (and finally a constant) is always preferred to waiting.
 */
class Fx
{
    /** Used only when there is no cache at all and the API is unreachable. */
    private const FALLBACK = 60.0;

    private const TTL = 43200; // 12h — the DOP rate barely moves intraday.

    /** After a failed fetch, don't hit the network again for this long. */
    private const RETRY_AFTER = 600; // 10 min

    private static ?array $memo = null;

    /**
     * @return array{rate: float, fetched_at: int, stale: bool, source: string}
     */
    public static function usdToDop(): array
    {
        if (self::$memo !== null) return self::$memo;

        $file = base_path('storage/cache/fx_usd_dop.json');
        $now  = time();

        $cached = is_file($file)
            ? (json_decode((string) file_get_contents($file), true) ?: null)
            : null;

        // Fresh cache wins — no network call at all.
        if ($cached && isset($cached['rate'], $cached['fetched_at'])
            && ($now - (int) $cached['fetched_at']) < self::TTL) {
            return self::$memo = [
                'rate'       => (float) $cached['rate'],
                'fetched_at' => (int) $cached['fetched_at'],
                'stale'      => false,
                'source'     => 'cache',
            ];
        }

        // A recent failure means the API is down; don't make every visitor wait
        // out the timeout again — serve stale/fallback until the backoff clears.
        $recentlyFailed = isset($cached['last_fail'])
            && ($now - (int) $cached['last_fail']) < self::RETRY_AFTER;

        $rate = $recentlyFailed ? null : self::fetch();

        if ($rate !== null) {
            self::write($file, ['rate' => $rate, 'fetched_at' => $now]);
            return self::$memo = [
                'rate'       => $rate,
                'fetched_at' => $now,
                'stale'      => false,
                'source'     => 'api',
            ];
        }

        if (!$recentlyFailed) {
            // Remember the failure (keeping any known rate) so the next request
            // skips the network instead of stalling on it again.
            self::write($file, [
                'rate'       => $cached['rate']       ?? null,
                'fetched_at' => $cached['fetched_at'] ?? 0,
                'last_fail'  => $now,
            ]);
        }

        // API failed — an expired cache is still far better than a constant.
        if ($cached && isset($cached['rate']) && is_numeric($cached['rate'])) {
            return self::$memo = [
                'rate'       => (float) $cached['rate'],
                'fetched_at' => (int) ($cached['fetched_at'] ?? 0),
                'stale'      => true,
                'source'     => 'cache-stale',
            ];
        }

        return self::$memo = [
            'rate'       => self::FALLBACK,
            'fetched_at' => 0,
            'stale'      => true,
            'source'     => 'fallback',
        ];
    }

    private static function write(string $file, array $payload): void
    {
        $dir = dirname($file);
        if (!is_dir($dir)) @mkdir($dir, 0775, true);
        @file_put_contents($file, json_encode($payload));
    }

    private static function fetch(): ?float
    {
        if (!function_exists('curl_init')) return null;

        $ch = curl_init('https://open.er-api.com/v6/latest/USD');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 3,   // never stall a page render
            CURLOPT_CONNECTTIMEOUT => 2,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        $res = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($res === false || $status < 200 || $status >= 300) return null;

        $data = json_decode((string) $res, true);
        $rate = $data['rates']['DOP'] ?? null;
        if (!is_numeric($rate)) return null;

        $rate = (float) $rate;
        // Sanity band: reject a garbage response rather than quote nonsense.
        if ($rate < 40 || $rate > 120) return null;

        return $rate;
    }

    /** Round a DOP amount to a legible bracket edge (nearest 25k). */
    public static function roundDop(float $amount): int
    {
        if ($amount <= 0) return 0;
        $step = $amount >= 1000000 ? 50000 : 25000;
        return (int) (round($amount / $step) * $step);
    }

    public static function formatDop(int $amount): string
    {
        return 'RD$' . number_format($amount);
    }

    public static function formatUsd(int $amount): string
    {
        return 'US$' . number_format($amount);
    }
}
