<?php
declare(strict_types=1);

session_start();

// ── Bootstrap ────────────────────────────────────────────────
require __DIR__ . '/app/env.php';
load_env(__DIR__ . '/.env');

require __DIR__ . '/app/helpers.php';
require __DIR__ . '/app/view.php';
require __DIR__ . '/app/router.php';

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

$router->get('/', fn() => render_view('home', [], [
    'title'       => 'KYROS Solutions · Soluciones tecnológicas, seguras e inteligentes',
    'description' => 'Desarrollo de software a medida, ciberseguridad avanzada, soporte IT 24/7 e infraestructura de redes para potenciar y proteger tu empresa.',
]));

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

$router->get('/about', fn() => render_view('about', [], [
    'title'       => 'Sobre Nosotros · KYROS Solutions',
    'description' => 'Conoce al equipo y la misión detrás de KYROS Solutions: tecnología que transforma empresas en Latinoamérica.',
]));

$router->get('/privacy', fn() => render_view('privacy', [], [
    'title' => 'Política de Privacidad · KYROS Solutions',
]));

$router->get('/terms', fn() => render_view('terms', [], [
    'title' => 'Términos y Condiciones · KYROS Solutions',
]));

$router->get('/contact', [ContactController::class, 'show']);
$router->post('/contact', [ContactController::class, 'submit']);

// Lazy-load contact controller
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/app/controllers/' . $class . '.php';
    if (is_file($file)) require $file;
});

// ── Dispatch ─────────────────────────────────────────────────
$router->dispatch();
