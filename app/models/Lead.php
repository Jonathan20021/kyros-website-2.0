<?php
declare(strict_types=1);

class Lead
{
    /** Status values allowed by the ENUM column. */
    public const STATUSES = ['nuevo', 'contactado', 'propuesta', 'ganado', 'perdido'];

    /** Human-readable reference shown to the client (e.g. KY-7F3A2B). */
    public static function makeRef(): string
    {
        return 'KY-' . strtoupper(bin2hex(random_bytes(3)));
    }

    public static function create(array $d): int
    {
        $sql = "INSERT INTO leads
            (ref, name, email, company, phone, services, project_type, description, goals, features,
             has_existing, existing_url, budget, timeline, heard_from, status, ip, user_agent)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        Database::pdo()->prepare($sql)->execute([
            $d['ref'],
            $d['name'],
            $d['email'],
            $d['company']      ?: null,
            $d['phone']        ?: null,
            $d['services']     ?: null,
            $d['project_type'] ?: null,
            $d['description']  ?: null,
            $d['goals']        ?: null,
            $d['features']     ?: null,
            $d['has_existing'] ?: null,
            $d['existing_url'] ?: null,
            $d['budget']       ?: null,
            $d['timeline']     ?: null,
            $d['heard_from']   ?: null,
            $d['status'] ?? 'nuevo',
            $d['ip']         ?? null,
            $d['user_agent'] ?? null,
        ]);
        return (int) Database::pdo()->lastInsertId();
    }

    /** Record which of the two emails actually went out. */
    public static function markMail(int $id, bool $adminOk, bool $clientOk): void
    {
        Database::pdo()
            ->prepare("UPDATE leads SET mail_admin_ok = ?, mail_client_ok = ? WHERE id = ?")
            ->execute([(int) $adminOk, (int) $clientOk, $id]);
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM leads WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /** @return array<int,array<string,mixed>> */
    public static function all(string $status = ''): array
    {
        if ($status !== '' && in_array($status, self::STATUSES, true)) {
            $stmt = Database::pdo()->prepare("SELECT * FROM leads WHERE status = ? ORDER BY created_at DESC, id DESC");
            $stmt->execute([$status]);
            return $stmt->fetchAll();
        }
        return Database::pdo()->query("SELECT * FROM leads ORDER BY created_at DESC, id DESC")->fetchAll();
    }

    public static function setStatus(int $id, string $status): void
    {
        if (!in_array($status, self::STATUSES, true)) return;
        Database::pdo()->prepare("UPDATE leads SET status = ? WHERE id = ?")->execute([$status, $id]);
    }

    public static function setNotes(int $id, string $notes): void
    {
        Database::pdo()->prepare("UPDATE leads SET admin_notes = ? WHERE id = ?")->execute([$notes, $id]);
    }

    public static function delete(int $id): void
    {
        Database::pdo()->prepare("DELETE FROM leads WHERE id = ?")->execute([$id]);
    }

    public static function count(string $status = ''): int
    {
        if ($status !== '' && in_array($status, self::STATUSES, true)) {
            $stmt = Database::pdo()->prepare("SELECT COUNT(*) FROM leads WHERE status = ?");
            $stmt->execute([$status]);
            return (int) $stmt->fetchColumn();
        }
        return (int) Database::pdo()->query("SELECT COUNT(*) FROM leads")->fetchColumn();
    }

    /** Counts per status in one query, for the admin filter chips. */
    public static function countsByStatus(): array
    {
        $out = array_fill_keys(self::STATUSES, 0);
        $rows = Database::pdo()->query("SELECT status, COUNT(*) c FROM leads GROUP BY status")->fetchAll();
        foreach ($rows as $r) {
            $out[$r['status']] = (int) $r['c'];
        }
        return $out;
    }
}
