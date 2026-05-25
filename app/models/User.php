<?php
declare(strict_types=1);

class User
{
    public static function find(int $id): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function findByEmail(string $email): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([strtolower(trim($email))]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $data): int
    {
        $stmt = Database::pdo()->prepare(
            "INSERT INTO users (name, email, password, role, bio) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['name'],
            strtolower(trim($data['email'])),
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role'] ?? 'admin',
            $data['bio'] ?? null,
        ]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $fields = [];
        $values = [];
        foreach (['name', 'email', 'bio', 'avatar'] as $col) {
            if (array_key_exists($col, $data)) {
                $fields[] = "$col = ?";
                $values[] = $col === 'email' ? strtolower(trim($data[$col])) : $data[$col];
            }
        }
        if (!empty($data['password'])) {
            $fields[] = "password = ?";
            $values[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        if (!$fields) return;
        $values[] = $id;
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        Database::pdo()->prepare($sql)->execute($values);
    }

    public static function verifyLogin(string $email, string $password): ?array
    {
        $user = self::findByEmail($email);
        if (!$user) return null;
        if (!password_verify($password, $user['password'])) return null;
        return $user;
    }

    public static function count(): int
    {
        return (int) Database::pdo()->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }
}
