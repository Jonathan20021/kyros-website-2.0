<?php
declare(strict_types=1);

/**
 * Handle a single file upload. Returns the public URL on success, null on failure or no file.
 * Stores under /assets/uploads/YYYY/MM/<hash>.<ext>
 */
function upload_image(?array $file, ?string &$error = null): ?string
{
    if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if (($file['error'] ?? 0) !== UPLOAD_ERR_OK) {
        $error = 'Error de subida (código ' . $file['error'] . ').';
        return null;
    }
    $maxBytes = 12 * 1024 * 1024; // 12 MB
    if ($file['size'] > $maxBytes) {
        $error = 'Archivo demasiado grande (máx 12 MB).';
        return null;
    }
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
        'image/svg+xml' => 'svg',
        'image/avif' => 'avif',
    ];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']) ?: ($file['type'] ?? '');
    if (!isset($allowed[$mime])) {
        $error = 'Tipo de imagen no soportado: ' . htmlspecialchars($mime);
        return null;
    }
    $ext = $allowed[$mime];
    $year = date('Y');
    $month = date('m');
    $dir = base_path("assets/uploads/{$year}/{$month}");
    if (!is_dir($dir)) {
        @mkdir($dir, 0775, true);
    }
    $hash = bin2hex(random_bytes(8));
    $name = $hash . '.' . $ext;
    $dest = $dir . DIRECTORY_SEPARATOR . $name;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        $error = 'No se pudo guardar el archivo.';
        return null;
    }

    // Store record in media table for the library
    try {
        $url = "/assets/uploads/{$year}/{$month}/{$name}";
        $stmt = Database::pdo()->prepare(
            "INSERT INTO media (filename, original_name, mime_type, size, url, uploaded_by) VALUES (?,?,?,?,?,?)"
        );
        $stmt->execute([
            $name,
            $file['name'] ?? null,
            $mime,
            $file['size'] ?? null,
            $url,
            $_SESSION['admin_id'] ?? null,
        ]);
    } catch (Throwable $e) {
        // Media table is non-critical; ignore
    }

    // Return APP_URL-relative URL
    $base = rtrim((string) env('APP_URL', ''), '/');
    return $base . "/assets/uploads/{$year}/{$month}/{$name}";
}

/** Slug generator — accent-folded kebab-case */
function slugify(string $text): string
{
    $text = trim($text);
    $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text) ?: $text;
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
    $text = trim((string) $text, '-');
    return $text ?: ('item-' . substr(bin2hex(random_bytes(3)), 0, 6));
}

/** Ensure slug is unique in the given table */
function ensure_unique_slug(string $table, string $slug, ?int $exceptId = null): string
{
    $base = $slug;
    $i = 1;
    while (true) {
        $sql = "SELECT id FROM `{$table}` WHERE slug = ?" . ($exceptId ? " AND id != ?" : "");
        $stmt = Database::pdo()->prepare($sql);
        $params = $exceptId ? [$slug, $exceptId] : [$slug];
        $stmt->execute($params);
        if (!$stmt->fetchColumn()) return $slug;
        $i++;
        $slug = $base . '-' . $i;
    }
}
