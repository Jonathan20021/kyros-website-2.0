<?php
declare(strict_types=1);

class Project
{
    public static function all(string $status = 'published', int $limit = 0, bool $featuredOnly = false): array
    {
        $sql = "SELECT * FROM projects WHERE status = ?";
        $params = [$status];
        if ($featuredOnly) $sql .= " AND featured = 1";
        $sql .= " ORDER BY sort_order ASC, id DESC";
        if ($limit > 0) $sql .= " LIMIT " . (int) $limit;
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function allAdmin(): array
    {
        return Database::pdo()->query("SELECT * FROM projects ORDER BY sort_order ASC, id DESC")->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM projects WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $d): int
    {
        $sql = "INSERT INTO projects
            (slug, title, client, category, description, content, cover_image, gallery, tags, metric, external_url, year, color_theme, status, featured, sort_order)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute([
            $d['slug'],
            $d['title'],
            $d['client'] ?? null,
            $d['category'] ?? null,
            $d['description'] ?? null,
            $d['content'] ?? null,
            $d['cover_image'] ?? null,
            $d['gallery'] ?? null,
            $d['tags'] ?? null,
            $d['metric'] ?? null,
            $d['external_url'] ?? null,
            $d['year'] ?? null,
            $d['color_theme'] ?? 'dark',
            $d['status'] ?? 'published',
            (int) ($d['featured'] ?? 0),
            (int) ($d['sort_order'] ?? 0),
        ]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function update(int $id, array $d): void
    {
        $fields = ['slug','title','client','category','description','content','cover_image','gallery','tags','metric','external_url','year','color_theme','status','featured','sort_order'];
        $set = [];
        $values = [];
        foreach ($fields as $f) {
            if (array_key_exists($f, $d)) {
                $set[] = "$f = ?";
                $values[] = in_array($f, ['featured','sort_order']) ? (int)$d[$f] : $d[$f];
            }
        }
        if (!$set) return;
        $values[] = $id;
        $sql = "UPDATE projects SET " . implode(', ', $set) . " WHERE id = ?";
        Database::pdo()->prepare($sql)->execute($values);
    }

    public static function delete(int $id): void
    {
        Database::pdo()->prepare("DELETE FROM projects WHERE id = ?")->execute([$id]);
    }

    public static function count(string $status = ''): int
    {
        if ($status) {
            $stmt = Database::pdo()->prepare("SELECT COUNT(*) FROM projects WHERE status = ?");
            $stmt->execute([$status]);
            return (int) $stmt->fetchColumn();
        }
        return (int) Database::pdo()->query("SELECT COUNT(*) FROM projects")->fetchColumn();
    }
}
