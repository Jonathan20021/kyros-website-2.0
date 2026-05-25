<?php
declare(strict_types=1);

class Category
{
    public static function all(): array
    {
        return Database::pdo()->query("SELECT * FROM categories ORDER BY sort_order ASC, name ASC")->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM categories WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $d): int
    {
        $stmt = Database::pdo()->prepare(
            "INSERT INTO categories (slug, name, description, color, sort_order) VALUES (?,?,?,?,?)"
        );
        $stmt->execute([
            $d['slug'], $d['name'], $d['description'] ?? null,
            $d['color'] ?? '#F26522', (int)($d['sort_order'] ?? 0)
        ]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function update(int $id, array $d): void
    {
        $fields = ['slug', 'name', 'description', 'color', 'sort_order'];
        $set = [];
        $values = [];
        foreach ($fields as $f) {
            if (array_key_exists($f, $d)) {
                $set[] = "$f = ?";
                $values[] = $f === 'sort_order' ? (int)$d[$f] : $d[$f];
            }
        }
        if (!$set) return;
        $values[] = $id;
        Database::pdo()->prepare("UPDATE categories SET " . implode(', ', $set) . " WHERE id = ?")->execute($values);
    }

    public static function delete(int $id): void
    {
        Database::pdo()->prepare("DELETE FROM categories WHERE id = ?")->execute([$id]);
    }

    public static function count(): int
    {
        return (int) Database::pdo()->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    }
}
