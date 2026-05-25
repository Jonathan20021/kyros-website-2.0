<?php
declare(strict_types=1);

/**
 * Render a view inside the base layout.
 *  $view  -> dotted path inside views/  (e.g. "services.cybersecurity")
 *  $data  -> variables to extract into the view
 *  $meta  -> page-specific meta (title, description, og_image, body_class)
 */
function render_view(string $view, array $data = [], array $meta = []): void
{
    $viewPath = base_path('views/' . str_replace('.', '/', $view) . '.php');

    if (!is_file($viewPath)) {
        http_response_code(500);
        echo "View not found: " . htmlspecialchars($view);
        exit;
    }

    $defaults = [
        'title'       => env('APP_NAME', 'KYROS Solutions'),
        'description' => 'Soluciones tecnológicas, seguras e inteligentes para empresas modernas.',
        'og_image'    => url('assets/img/og-default.jpg'),
        'body_class'  => '',
        'canonical'   => url(current_path()),
    ];
    $meta = array_merge($defaults, $meta);

    extract($data, EXTR_SKIP);

    ob_start();
    require $viewPath;
    $content = ob_get_clean();

    require base_path('views/layouts/base.php');
}

/**
 * Render a partial (header, footer, fragment) without the layout.
 */
function partial(string $name, array $data = []): void
{
    extract($data, EXTR_SKIP);
    require base_path('views/partials/' . $name . '.php');
}

/**
 * Render an admin view wrapped inside the admin layout.
 *  $view -> dotted path inside views/admin/ (e.g. "projects.index")
 *  $data -> variables extracted into the view scope
 *  $meta -> admin chrome (adminTitle, adminSubtitle, adminAction HTML)
 */
function render_admin(string $view, array $data = [], array $meta = []): void
{
    $viewPath = base_path('views/admin/' . str_replace('.', '/', $view) . '.php');
    if (!is_file($viewPath)) {
        http_response_code(500);
        echo "Admin view not found: " . htmlspecialchars($view);
        exit;
    }
    $defaults = [
        'adminTitle'    => '',
        'adminSubtitle' => '',
        'adminAction'   => '',
    ];
    $meta = array_merge($defaults, $meta);
    extract($meta, EXTR_SKIP);
    extract($data, EXTR_SKIP);

    ob_start();
    require $viewPath;
    $content = ob_get_clean();

    require base_path('views/admin/layout.php');
}

/**
 * Bare admin view (no layout) — for login/install pages.
 */
function render_admin_bare(string $view, array $data = []): void
{
    $viewPath = base_path('views/admin/' . str_replace('.', '/', $view) . '.php');
    if (!is_file($viewPath)) {
        http_response_code(500);
        echo "Admin view not found: " . htmlspecialchars($view);
        exit;
    }
    extract($data, EXTR_SKIP);
    require $viewPath;
}
