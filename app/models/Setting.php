<?php
declare(strict_types=1);

class Setting
{
    private static array $cache = [];

    public static function get(string $key, ?string $default = null): ?string
    {
        if (isset(self::$cache[$key])) return self::$cache[$key];
        $stmt = Database::pdo()->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $v = $stmt->fetchColumn();
        self::$cache[$key] = $v !== false ? $v : $default;
        return self::$cache[$key];
    }

    public static function set(string $key, ?string $value): void
    {
        $stmt = Database::pdo()->prepare(
            "INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)"
        );
        $stmt->execute([$key, $value]);
        self::$cache[$key] = $value;
    }
}
