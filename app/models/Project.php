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

    /** Distinct non-empty categories across all projects, for the datalist. */
    public static function distinctCategories(): array
    {
        $rows = Database::pdo()
            ->query("SELECT DISTINCT category FROM projects WHERE category IS NOT NULL AND category <> '' ORDER BY category ASC")
            ->fetchAll(PDO::FETCH_COLUMN);
        return $rows ?: [];
    }

    /**
     * Every tag ever used, de-duplicated case-insensitively, for the suggestion
     * chips. Tags live comma-separated in one column, so they are split here
     * rather than in the view.
     *
     * @return array<int,string>
     */
    public static function distinctTags(int $limit = 24): array
    {
        $rows = Database::pdo()
            ->query("SELECT tags FROM projects WHERE tags IS NOT NULL AND tags <> ''")
            ->fetchAll(PDO::FETCH_COLUMN);

        $seen = [];
        foreach ($rows as $csv) {
            foreach (explode(',', (string) $csv) as $tag) {
                $tag = trim($tag);
                if ($tag === '') continue;
                $key = mb_strtolower($tag);
                if (!isset($seen[$key])) $seen[$key] = $tag;   // keep first-seen casing
            }
        }
        ksort($seen);
        return array_slice(array_values($seen), 0, $limit);
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
