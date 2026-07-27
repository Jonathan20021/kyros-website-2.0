<?php
declare(strict_types=1);

class Post
{
    public static function published(int $limit = 12, int $offset = 0, ?int $categoryId = null): array
    {
        $sql = "SELECT p.*, c.name AS category_name, c.slug AS category_slug, c.color AS category_color,
                       u.name AS author_name
                FROM posts p
                LEFT JOIN categories c ON c.id = p.category_id
                LEFT JOIN users u ON u.id = p.author_id
                WHERE p.status = 'published' AND (p.published_at IS NULL OR p.published_at <= NOW())";
        $params = [];
        if ($categoryId) {
            $sql .= " AND p.category_id = ?";
            $params[] = $categoryId;
        }
        $sql .= " ORDER BY COALESCE(p.published_at, p.created_at) DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $stmt = Database::pdo()->prepare($sql);
        // Bind params: LIMIT/OFFSET need to be integers
        foreach ($params as $i => $v) {
            $stmt->bindValue($i + 1, $v, is_int($v) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function countPublished(?int $categoryId = null): int
    {
        $sql = "SELECT COUNT(*) FROM posts WHERE status='published' AND (published_at IS NULL OR published_at <= NOW())";
        $params = [];
        if ($categoryId) {
            $sql .= " AND category_id = ?";
            $params[] = $categoryId;
        }
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public static function allAdmin(): array
    {
        return Database::pdo()->query(
            "SELECT p.*, c.name AS category_name, u.name AS author_name
             FROM posts p
             LEFT JOIN categories c ON c.id = p.category_id
             LEFT JOIN users u ON u.id = p.author_id
             ORDER BY p.id DESC"
        )->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = Database::pdo()->prepare(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug, c.color AS category_color,
                    u.name AS author_name, u.bio AS author_bio, u.avatar AS author_avatar
             FROM posts p
             LEFT JOIN categories c ON c.id = p.category_id
             LEFT JOIN users u ON u.id = p.author_id
             WHERE p.slug = ?"
        );
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $d): int
    {
        $sql = "INSERT INTO posts
            (slug, title, excerpt, content, cover_image, author_id, category_id, tags, reading_time,
             status, featured, meta_title, meta_description, published_at)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute([
            $d['slug'],
            $d['title'],
            $d['excerpt'] ?? null,
            $d['content'] ?? null,
            $d['cover_image'] ?? null,
            $d['author_id'] ?? null,
            $d['category_id'] ?: null,
            $d['tags'] ?? null,
            (int) ($d['reading_time'] ?? 1),
            $d['status'] ?? 'draft',
            (int) ($d['featured'] ?? 0),
            $d['meta_title'] ?? null,
            $d['meta_description'] ?? null,
            ($d['status'] ?? 'draft') === 'published' ? ($d['published_at'] ?? date('Y-m-d H:i:s')) : null,
        ]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function update(int $id, array $d): void
    {
        $fields = ['slug','title','excerpt','content','cover_image','category_id','tags','reading_time',
                   'status','featured','meta_title','meta_description','published_at'];
        $set = [];
        $values = [];
        foreach ($fields as $f) {
            if (array_key_exists($f, $d)) {
                $set[] = "$f = ?";
                if (in_array($f, ['featured','reading_time'])) {
                    $values[] = (int) $d[$f];
                } elseif ($f === 'category_id') {
                    $values[] = $d[$f] ?: null;
                } else {
                    $values[] = $d[$f];
                }
            }
        }
        if (!$set) return;
        $values[] = $id;
        $sql = "UPDATE posts SET " . implode(', ', $set) . " WHERE id = ?";
        Database::pdo()->prepare($sql)->execute($values);
    }

    public static function delete(int $id): void
    {
        Database::pdo()->prepare("DELETE FROM posts WHERE id = ?")->execute([$id]);
    }

    public static function incrementViews(int $id): void
    {
        Database::pdo()->prepare("UPDATE posts SET views = views + 1 WHERE id = ?")->execute([$id]);
    }

    /**
     * Every tag ever used across posts, de-duplicated case-insensitively, for
     * the suggestion chips. Tags live comma-separated in one column.
     *
     * @return array<int,string>
     */
    public static function distinctTags(int $limit = 24): array
    {
        $rows = Database::pdo()
            ->query("SELECT tags FROM posts WHERE tags IS NOT NULL AND tags <> ''")
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
            $stmt = Database::pdo()->prepare("SELECT COUNT(*) FROM posts WHERE status = ?");
            $stmt->execute([$status]);
            return (int) $stmt->fetchColumn();
        }
        return (int) Database::pdo()->query("SELECT COUNT(*) FROM posts")->fetchColumn();
    }

    public static function related(int $postId, ?int $categoryId, int $limit = 3): array
    {
        if ($categoryId) {
            $stmt = Database::pdo()->prepare(
                "SELECT p.*, c.name AS category_name, c.color AS category_color
                 FROM posts p LEFT JOIN categories c ON c.id = p.category_id
                 WHERE p.id != ? AND p.status='published' AND p.category_id = ?
                 ORDER BY p.published_at DESC LIMIT ?"
            );
            $stmt->bindValue(1, $postId, PDO::PARAM_INT);
            $stmt->bindValue(2, $categoryId, PDO::PARAM_INT);
            $stmt->bindValue(3, $limit, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if (count($rows) >= $limit) return $rows;
        }
        // Fallback: just recent
        $stmt = Database::pdo()->prepare(
            "SELECT p.*, c.name AS category_name, c.color AS category_color
             FROM posts p LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.id != ? AND p.status='published'
             ORDER BY p.published_at DESC LIMIT ?"
        );
        $stmt->bindValue(1, $postId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
