<?php
declare(strict_types=1);

session_start();

// ── Bootstrap ────────────────────────────────────────────────
require __DIR__ . '/app/env.php';
load_env(__DIR__ . '/.env');

require __DIR__ . '/app/helpers.php';
require __DIR__ . '/app/view.php';
require __DIR__ . '/app/router.php';

// Autoload models, controllers, database, auth
spl_autoload_register(function ($class) {
    foreach (['controllers', 'models', 'database'] as $dir) {
        $file = __DIR__ . "/app/{$dir}/{$class}.php";
        if (is_file($file)) { require $file; return; }
    }
});

// Auth + upload helpers (procedural, always loaded for admin/blog flows)
require __DIR__ . '/app/auth.php';
require __DIR__ . '/app/upload.php';

// Icon helper — available globally (admin views render BEFORE the layout includes it)
require_once __DIR__ . '/views/partials/icons.php';

// Errors visible only when APP_DEBUG=true
if (env('APP_DEBUG', false)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ERROR | E_PARSE);
    ini_set('display_errors', '0');
}

// ── Routes ───────────────────────────────────────────────────
$router = new Router();

/* ── Public landing + service pages ───────────────────────── */
$router->get('/', [HomeController::class, 'index']);

$router->get('/services', fn() => render_view('services.index', [], [
    'title'       => 'Servicios · KYROS Solutions',
    'description' => 'Desarrollo de software, ciberseguridad, soporte técnico e infraestructura de redes. Una solución integral para tu empresa.',
]));
$router->get('/services/software-development', fn() => render_view('services.software-development', [], [
    'title'       => 'Desarrollo de Software a Medida · KYROS Solutions',
    'description' => 'Aplicaciones web, sistemas empresariales y plataformas SaaS construidas con tecnologías modernas y arquitectura escalable.',
]));
$router->get('/services/cybersecurity', fn() => render_view('services.cybersecurity', [], [
    'title'       => 'Ciberseguridad Avanzada · KYROS Solutions',
    'description' => 'Auditorías, pentesting, protección perimetral y monitoreo continuo para blindar la operación de tu empresa.',
]));
$router->get('/services/technical-support', fn() => render_view('services.technical-support', [], [
    'title'       => 'Soporte Técnico & Helpdesk 24/7 · KYROS Solutions',
    'description' => 'Mesa de ayuda profesional, soporte remoto y on-site con SLA garantizado para mantener tu operación 100% funcional.',
]));
$router->get('/services/network-infrastructure', fn() => render_view('services.network-infrastructure', [], [
    'title'       => 'Infraestructura de Redes · KYROS Solutions',
    'description' => 'Diseño, implementación y administración de redes empresariales seguras, escalables y de alto rendimiento.',
]));
$router->get('/services/social-media', fn() => render_view('services.social-media', [], [
    'title'       => 'Manejo de Redes Sociales · KYROS Solutions',
    'description' => 'Estrategia, contenido, community management y campañas para empresas y marcas personales. Hacemos crecer tu presencia digital.',
]));
$router->get('/services/medical-websites', fn() => render_view('services.medical-websites', [], [
    'title'       => 'Páginas Web para Médicos y Especialistas · KYROS Solutions',
    'description' => 'Sitios web profesionales para médicos, odontólogos, psicólogos y centros de salud. Perfil, consultorios, horarios y solicitud de citas. Desde RD$12,900 y entrega en 7 días.',
]));

$router->get('/about',   fn() => render_view('about',   [], ['title' => 'Sobre Nosotros · KYROS Solutions', 'description' => 'Conoce al equipo y la misión detrás de KYROS Solutions.']));
$router->get('/privacy', fn() => render_view('privacy', [], ['title' => 'Política de Privacidad · KYROS Solutions']));
$router->get('/terms',   fn() => render_view('terms',   [], ['title' => 'Términos y Condiciones · KYROS Solutions']));

$router->get('/contact',  [ContactController::class, 'show']);
$router->post('/contact', [ContactController::class, 'submit']);

/* ── Project brief ("Hablemos del proyecto") ─────────────── */
$router->get('/hablemos',  [BriefController::class, 'show']);
$router->post('/hablemos', [BriefController::class, 'submit']);

/* ── Doctor intake ("Páginas web para médicos") ──────────── */
$router->get('/mi-pagina-medica',  [MedicalSiteController::class, 'show']);
$router->post('/mi-pagina-medica', [MedicalSiteController::class, 'submit']);

/* ── Public blog ──────────────────────────────────────────── */
$router->get('/blog',                       [BlogController::class, 'index']);
$router->get('/blog/categoria/{slug}',      [BlogController::class, 'byCategory']);
$router->get('/blog/{slug}',                [BlogController::class, 'show']);

/* ── Public projects ──────────────────────────────────────── */
$router->get('/proyectos',                  [ProjectsPublicController::class, 'index']);
$router->get('/proyectos/{slug}',           [ProjectsPublicController::class, 'show']);

/* ── Admin auth ──────────────────────────────────────────── */
$router->get('/admin/install',  [AdminController::class, 'installForm']);
$router->post('/admin/install', [AdminController::class, 'install']);
$router->get('/admin/login',    [AdminController::class, 'loginForm']);
$router->post('/admin/login',   [AdminController::class, 'login']);
$router->get('/admin/logout',   [AdminController::class, 'logout']);

/* ── Admin (protected by middleware in each controller) ──── */
$router->get('/admin',                       [AdminController::class, 'dashboard']);

$router->get('/admin/projects',              [ProjectAdminController::class, 'index']);
$router->get('/admin/projects/new',          [ProjectAdminController::class, 'create']);
$router->post('/admin/projects/store',       [ProjectAdminController::class, 'store']);
$router->get('/admin/projects/{id}/edit',    [ProjectAdminController::class, 'edit']);
$router->post('/admin/projects/{id}/update', [ProjectAdminController::class, 'update']);
$router->post('/admin/projects/{id}/delete', [ProjectAdminController::class, 'destroy']);

$router->get('/admin/posts',                 [PostAdminController::class, 'index']);
$router->get('/admin/posts/new',             [PostAdminController::class, 'create']);
$router->post('/admin/posts/store',          [PostAdminController::class, 'store']);
$router->get('/admin/posts/{id}/edit',       [PostAdminController::class, 'edit']);
$router->post('/admin/posts/{id}/update',    [PostAdminController::class, 'update']);
$router->post('/admin/posts/{id}/delete',    [PostAdminController::class, 'destroy']);

$router->get('/admin/categories',            [CategoryAdminController::class, 'index']);
$router->post('/admin/categories/store',     [CategoryAdminController::class, 'store']);
$router->post('/admin/categories/{id}/update', [CategoryAdminController::class, 'update']);
$router->post('/admin/categories/{id}/delete', [CategoryAdminController::class, 'destroy']);
$router->post('/admin/categories/ajax-store',[CategoryAdminController::class, 'ajaxStore']);

$router->get('/admin/leads',                 [LeadAdminController::class, 'index']);
$router->get('/admin/leads/{id}',            [LeadAdminController::class, 'show']);
$router->post('/admin/leads/{id}/status',    [LeadAdminController::class, 'updateStatus']);
$router->post('/admin/leads/{id}/notes',     [LeadAdminController::class, 'updateNotes']);
$router->post('/admin/leads/{id}/delete',    [LeadAdminController::class, 'destroy']);

$router->get('/admin/medicos',               [MedicalAdminController::class, 'index']);
$router->get('/admin/medicos/{id}',          [MedicalAdminController::class, 'show']);
$router->post('/admin/medicos/{id}/status',  [MedicalAdminController::class, 'updateStatus']);
$router->post('/admin/medicos/{id}/notes',   [MedicalAdminController::class, 'updateNotes']);
$router->post('/admin/medicos/{id}/delete',  [MedicalAdminController::class, 'destroy']);

$router->get('/admin/settings',              [AdminController::class, 'settings']);
$router->post('/admin/settings',             [AdminController::class, 'updateSettings']);

/* ── SEO ─────────────────────────────────────────────────── */
$router->get('/sitemap.xml', function () {
    header('Content-Type: application/xml; charset=UTF-8');
    $now = date('c');
    $base = rtrim((string) env('APP_URL', ''), '/');
    $paths = [
        ['/',                                  '1.0', 'weekly'],
        ['/blog',                              '0.9', 'weekly'],
        ['/proyectos',                         '0.9', 'monthly'],
        ['/services',                          '0.9', 'monthly'],
        ['/services/software-development',     '0.8', 'monthly'],
        ['/services/cybersecurity',            '0.8', 'monthly'],
        ['/services/technical-support',        '0.8', 'monthly'],
        ['/services/network-infrastructure',   '0.8', 'monthly'],
        ['/services/social-media',             '0.8', 'monthly'],
        ['/services/medical-websites',         '0.9', 'monthly'],
        ['/about',                             '0.7', 'monthly'],
        ['/contact',                           '0.7', 'monthly'],
        ['/hablemos',                          '0.9', 'monthly'],
        ['/mi-pagina-medica',                  '0.8', 'monthly'],
    ];
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";
    foreach ($paths as [$p, $pri, $freq]) {
        $loc = htmlspecialchars($base . $p, ENT_XML1);
        echo "  <url><loc>{$loc}</loc><lastmod>{$now}</lastmod><changefreq>{$freq}</changefreq><priority>{$pri}</priority></url>\n";
    }
    // Append posts + projects dynamically
    try {
        foreach (Database::pdo()->query("SELECT slug, updated_at FROM posts WHERE status='published'") as $r) {
            $loc = htmlspecialchars($base . '/blog/' . $r['slug'], ENT_XML1);
            $lm = date('c', strtotime($r['updated_at']));
            echo "  <url><loc>{$loc}</loc><lastmod>{$lm}</lastmod><changefreq>monthly</changefreq><priority>0.7</priority></url>\n";
        }
        foreach (Database::pdo()->query("SELECT slug, updated_at FROM projects WHERE status='published'") as $r) {
            $loc = htmlspecialchars($base . '/proyectos/' . $r['slug'], ENT_XML1);
            $lm = date('c', strtotime($r['updated_at']));
            echo "  <url><loc>{$loc}</loc><lastmod>{$lm}</lastmod><changefreq>monthly</changefreq><priority>0.7</priority></url>\n";
        }
    } catch (Throwable $e) { /* DB not ready yet */ }
    echo "</urlset>\n";
});

$router->get('/robots.txt', function () {
    header('Content-Type: text/plain; charset=UTF-8');
    $base = rtrim((string) env('APP_URL', ''), '/');
    echo "User-agent: *\n";
    echo "Allow: /\n";
    echo "Disallow: /admin/\n";
    echo "Disallow: /app/\n";
    echo "Disallow: /storage/\n";
    echo "Disallow: /node_modules/\n\n";
    echo "Sitemap: {$base}/sitemap.xml\n";
});

// ── Dispatch ─────────────────────────────────────────────────
$router->dispatch();
