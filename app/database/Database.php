<?php
declare(strict_types=1);

/**
 * MySQL/PDO singleton. Auto-creates the database if it doesn't exist.
 * On first call, runs schema migrations (idempotent).
 */
class Database
{
    private static ?PDO $pdo = null;
    private static bool $migrated = false;

    public static function pdo(): PDO
    {
        if (self::$pdo !== null) return self::$pdo;

        $host = env('DB_HOST', '127.0.0.1');
        $port = env('DB_PORT', '3306');
        $name = env('DB_NAME', 'kyros_cms');
        $user = env('DB_USER', 'root');
        $pass = env('DB_PASS', '');

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        // Connect WITHOUT db name first → auto-create if missing
        try {
            $bootDsn = "mysql:host={$host};port={$port};charset=utf8mb4";
            $bootPdo = new PDO($bootDsn, $user, $pass, $options);
            $bootPdo->exec("CREATE DATABASE IF NOT EXISTS `{$name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        } catch (PDOException $e) {
            throw new RuntimeException("DB connection failed: " . $e->getMessage());
        }

        // Connect to the actual database
        $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
        self::$pdo = new PDO($dsn, $user, $pass, $options);
        self::$pdo->exec("SET time_zone = '-04:00'");

        if (!self::$migrated) {
            self::migrate();
            self::$migrated = true;
        }

        return self::$pdo;
    }

    /**
     * Idempotent schema migration. Safe to run on every request (cheap).
     * Uses CREATE TABLE IF NOT EXISTS.
     */
    public static function migrate(): void
    {
        $pdo = self::$pdo ?? self::pdo();

        $sql = <<<'SQL'
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(120) NOT NULL,
            email VARCHAR(180) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin','editor') DEFAULT 'admin',
            avatar VARCHAR(255) NULL,
            bio VARCHAR(500) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        SQL;
        $pdo->exec($sql);

        $sql = <<<'SQL'
        CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            slug VARCHAR(120) NOT NULL UNIQUE,
            name VARCHAR(120) NOT NULL,
            description VARCHAR(255) NULL,
            color VARCHAR(20) DEFAULT '#F26522',
            sort_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        SQL;
        $pdo->exec($sql);

        $sql = <<<'SQL'
        CREATE TABLE IF NOT EXISTS projects (
            id INT AUTO_INCREMENT PRIMARY KEY,
            slug VARCHAR(180) NOT NULL UNIQUE,
            title VARCHAR(180) NOT NULL,
            client VARCHAR(160) NULL,
            category VARCHAR(80) NULL,
            description TEXT NULL,
            content LONGTEXT NULL,
            cover_image VARCHAR(500) NULL,
            gallery TEXT NULL,
            tags VARCHAR(255) NULL,
            metric VARCHAR(200) NULL,
            external_url VARCHAR(500) NULL,
            year VARCHAR(20) NULL,
            color_theme VARCHAR(20) DEFAULT 'dark',
            status ENUM('draft','published') DEFAULT 'published',
            featured TINYINT DEFAULT 0,
            sort_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_status (status),
            INDEX idx_featured (featured),
            INDEX idx_sort (sort_order)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        SQL;
        $pdo->exec($sql);

        $sql = <<<'SQL'
        CREATE TABLE IF NOT EXISTS posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            slug VARCHAR(200) NOT NULL UNIQUE,
            title VARCHAR(200) NOT NULL,
            excerpt VARCHAR(500) NULL,
            content LONGTEXT NULL,
            cover_image VARCHAR(500) NULL,
            author_id INT NULL,
            category_id INT NULL,
            tags VARCHAR(255) NULL,
            reading_time INT DEFAULT 1,
            views INT DEFAULT 0,
            status ENUM('draft','published') DEFAULT 'draft',
            featured TINYINT DEFAULT 0,
            meta_title VARCHAR(200) NULL,
            meta_description VARCHAR(500) NULL,
            published_at TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_status_published (status, published_at),
            CONSTRAINT fk_post_author FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL,
            CONSTRAINT fk_post_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        SQL;
        $pdo->exec($sql);

        $sql = <<<'SQL'
        CREATE TABLE IF NOT EXISTS settings (
            setting_key VARCHAR(120) PRIMARY KEY,
            setting_value TEXT NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        SQL;
        $pdo->exec($sql);

        $sql = <<<'SQL'
        CREATE TABLE IF NOT EXISTS leads (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ref VARCHAR(20) NOT NULL UNIQUE,
            name VARCHAR(120) NOT NULL,
            email VARCHAR(180) NOT NULL,
            company VARCHAR(160) NULL,
            phone VARCHAR(40) NULL,
            services VARCHAR(255) NULL,
            project_type VARCHAR(80) NULL,
            description TEXT NULL,
            goals TEXT NULL,
            features TEXT NULL,
            has_existing VARCHAR(40) NULL,
            existing_url VARCHAR(500) NULL,
            budget VARCHAR(60) NULL,
            timeline VARCHAR(60) NULL,
            heard_from VARCHAR(80) NULL,
            status ENUM('nuevo','contactado','propuesta','ganado','perdido') DEFAULT 'nuevo',
            admin_notes TEXT NULL,
            ip VARCHAR(60) NULL,
            user_agent VARCHAR(255) NULL,
            mail_admin_ok TINYINT DEFAULT 0,
            mail_client_ok TINYINT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_status (status),
            INDEX idx_created (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        SQL;
        $pdo->exec($sql);

        /* Requests coming from "Páginas web para médicos" (/mi-pagina-medica).
           Kept apart from `leads`: this form collects the raw material of the
           site itself (bio, trayectoria, consultorios, horarios, logo), not a
           sales enquiry, and it follows a production pipeline of its own.
           Variable-length parts (consultorios + their weekly schedules, redes)
           are JSON so a doctor can add a third office without a migration. */
        $sql = <<<'SQL'
        CREATE TABLE IF NOT EXISTS medical_requests (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ref VARCHAR(20) NOT NULL UNIQUE,
            title_prefix VARCHAR(20) NULL,
            full_name VARCHAR(160) NOT NULL,
            specialty VARCHAR(120) NULL,
            specialty_other VARCHAR(160) NULL,
            subspecialty VARCHAR(200) NULL,
            license VARCHAR(60) NULL,
            years_experience VARCHAR(20) NULL,
            email VARCHAR(180) NOT NULL,
            phone VARCHAR(40) NOT NULL,
            whatsapp VARCHAR(40) NULL,
            city VARCHAR(120) NULL,
            domain_status VARCHAR(40) NULL,
            domain_name VARCHAR(180) NULL,
            socials TEXT NULL,
            bio TEXT NULL,
            career TEXT NULL,
            services_offered TEXT NULL,
            insurances TEXT NULL,
            languages VARCHAR(200) NULL,
            logo_url VARCHAR(500) NULL,
            portrait_url VARCHAR(500) NULL,
            clinics TEXT NULL,
            plan VARCHAR(40) NULL,
            extras VARCHAR(500) NULL,
            booking VARCHAR(40) NULL,
            design_refs VARCHAR(500) NULL,
            launch_when VARCHAR(40) NULL,
            notes TEXT NULL,
            status ENUM('nuevo','contactado','propuesta','en_produccion','publicado','perdido') DEFAULT 'nuevo',
            admin_notes TEXT NULL,
            ip VARCHAR(60) NULL,
            user_agent VARCHAR(255) NULL,
            mail_admin_ok TINYINT DEFAULT 0,
            mail_client_ok TINYINT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_med_status (status),
            INDEX idx_med_created (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        SQL;
        $pdo->exec($sql);

        $sql = <<<'SQL'
        CREATE TABLE IF NOT EXISTS media (
            id INT AUTO_INCREMENT PRIMARY KEY,
            filename VARCHAR(255) NOT NULL,
            original_name VARCHAR(255) NULL,
            mime_type VARCHAR(80) NULL,
            size INT NULL,
            url VARCHAR(500) NOT NULL,
            alt_text VARCHAR(255) NULL,
            uploaded_by INT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_uploaded_by (uploaded_by)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        SQL;
        $pdo->exec($sql);
    }

    /** Convenience: check if any admin user exists. */
    public static function hasAdmin(): bool
    {
        try {
            $count = self::pdo()->query("SELECT COUNT(*) FROM users WHERE role='admin'")->fetchColumn();
            return (int) $count > 0;
        } catch (Throwable $e) {
            return false;
        }
    }
}
