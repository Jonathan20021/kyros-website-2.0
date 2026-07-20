<?php
declare(strict_types=1);

/**
 * A doctor's request to have their website built (/mi-pagina-medica).
 *
 * Mirrors the Lead model's shape (static methods returning plain arrays), with
 * two additions: the pipeline runs past "won" into production/publication, and
 * `socials` + `clinics` are JSON columns decoded on read so the admin panel and
 * the emails never have to know the storage format.
 */
class MedicalRequest
{
    /** Status values allowed by the ENUM column, in pipeline order. */
    public const STATUSES = ['nuevo', 'contactado', 'propuesta', 'en_produccion', 'publicado', 'perdido'];

    public const STATUS_LABELS = [
        'nuevo'          => 'Nuevo',
        'contactado'     => 'Contactado',
        'propuesta'      => 'Propuesta enviada',
        'en_produccion'  => 'En producción',
        'publicado'      => 'Publicado',
        'perdido'        => 'Perdido',
    ];

    /** Human-readable reference shown to the doctor (e.g. MD-7F3A2B). */
    public static function makeRef(): string
    {
        return 'MD-' . strtoupper(bin2hex(random_bytes(3)));
    }

    public static function create(array $d): int
    {
        $sql = "INSERT INTO medical_requests
            (ref, title_prefix, full_name, specialty, specialty_other, subspecialty, license, years_experience,
             email, phone, whatsapp, city, domain_status, domain_name, socials,
             bio, career, services_offered, insurances, languages,
             logo_url, portrait_url, clinics,
             plan, extras, booking, design_refs, launch_when, notes,
             status, ip, user_agent)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        Database::pdo()->prepare($sql)->execute([
            $d['ref'],
            $d['title_prefix']     ?: null,
            $d['full_name'],
            $d['specialty']        ?: null,
            $d['specialty_other']  ?: null,
            $d['subspecialty']     ?: null,
            $d['license']          ?: null,
            $d['years_experience'] ?: null,
            $d['email'],
            $d['phone'],
            $d['whatsapp']         ?: null,
            $d['city']             ?: null,
            $d['domain_status']    ?: null,
            $d['domain_name']      ?: null,
            self::encode($d['socials'] ?? []),
            $d['bio']              ?: null,
            $d['career']           ?: null,
            $d['services_offered'] ?: null,
            $d['insurances']       ?: null,
            $d['languages']        ?: null,
            $d['logo_url']         ?: null,
            $d['portrait_url']     ?: null,
            self::encode($d['clinics'] ?? []),
            $d['plan']             ?: null,
            $d['extras']           ?: null,
            $d['booking']          ?: null,
            $d['design_refs']      ?: null,
            $d['launch_when']      ?: null,
            $d['notes']            ?: null,
            $d['status'] ?? 'nuevo',
            $d['ip']         ?? null,
            $d['user_agent'] ?? null,
        ]);

        return (int) Database::pdo()->lastInsertId();
    }

    /**
     * JSON for a TEXT column: null when empty so the admin panel can use a plain
     * empty check, and never a PHP-serialised blob a human can't read in MySQL.
     */
    private static function encode(array $value): ?string
    {
        if (!$value) return null;
        // Invalid UTF-8 already got repaired upstream; still, never let a JSON
        // failure abort the INSERT and lose the whole request.
        $json = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
        return $json === false ? null : $json;
    }

    /** @return array<int|string,mixed> Decoded JSON column, [] when absent/corrupt. */
    public static function decode(?string $json): array
    {
        if (!$json) return [];
        $out = json_decode($json, true);
        return is_array($out) ? $out : [];
    }

    /** Record which of the two emails actually went out. */
    public static function markMail(int $id, bool $adminOk, bool $clientOk): void
    {
        Database::pdo()
            ->prepare("UPDATE medical_requests SET mail_admin_ok = ?, mail_client_ok = ? WHERE id = ?")
            ->execute([(int) $adminOk, (int) $clientOk, $id]);
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM medical_requests WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /** @return array<int,array<string,mixed>> */
    public static function all(string $status = ''): array
    {
        if ($status !== '' && in_array($status, self::STATUSES, true)) {
            $stmt = Database::pdo()->prepare(
                "SELECT * FROM medical_requests WHERE status = ? ORDER BY created_at DESC, id DESC"
            );
            $stmt->execute([$status]);
            return $stmt->fetchAll();
        }
        return Database::pdo()
            ->query("SELECT * FROM medical_requests ORDER BY created_at DESC, id DESC")
            ->fetchAll();
    }

    public static function setStatus(int $id, string $status): void
    {
        if (!in_array($status, self::STATUSES, true)) return;
        Database::pdo()->prepare("UPDATE medical_requests SET status = ? WHERE id = ?")->execute([$status, $id]);
    }

    public static function setNotes(int $id, string $notes): void
    {
        Database::pdo()->prepare("UPDATE medical_requests SET admin_notes = ? WHERE id = ?")->execute([$notes, $id]);
    }

    public static function delete(int $id): void
    {
        Database::pdo()->prepare("DELETE FROM medical_requests WHERE id = ?")->execute([$id]);
    }

    public static function count(string $status = ''): int
    {
        if ($status !== '' && in_array($status, self::STATUSES, true)) {
            $stmt = Database::pdo()->prepare("SELECT COUNT(*) FROM medical_requests WHERE status = ?");
            $stmt->execute([$status]);
            return (int) $stmt->fetchColumn();
        }
        return (int) Database::pdo()->query("SELECT COUNT(*) FROM medical_requests")->fetchColumn();
    }

    /** Counts per status in one query, for the admin filter chips. */
    public static function countsByStatus(): array
    {
        $out = array_fill_keys(self::STATUSES, 0);
        $rows = Database::pdo()->query("SELECT status, COUNT(*) c FROM medical_requests GROUP BY status")->fetchAll();
        foreach ($rows as $r) {
            $out[$r['status']] = (int) $r['c'];
        }
        return $out;
    }
}
