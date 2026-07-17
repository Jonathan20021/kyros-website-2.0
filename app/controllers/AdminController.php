<?php
declare(strict_types=1);

class AdminController
{
    /** Show install form (first admin) */
    public function installForm(): void
    {
        Database::pdo(); // ensure tables exist
        if (Database::hasAdmin()) {
            redirect('/admin/login');
        }
        render_admin_bare('install', ['error' => flash('error')]);
    }

    /** Process install form */
    public function install(): void
    {
        Database::pdo();
        if (Database::hasAdmin()) redirect('/admin/login');

        if (!csrf_check($_POST['_csrf'] ?? '')) {
            flash('error', 'Token de seguridad inválido. Recarga e intenta de nuevo.');
            set_old($_POST);
            redirect('/admin/install');
        }
        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $pass  = (string) ($_POST['password'] ?? '');
        $key   = trim($_POST['install_key'] ?? '');

        $expectedKey = env('ADMIN_INSTALL_KEY', '');
        if (!$expectedKey || !hash_equals($expectedKey, $key)) {
            flash('error', 'Clave de instalación incorrecta.');
            set_old($_POST);
            redirect('/admin/install');
        }
        if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 8) {
            flash('error', 'Datos inválidos. Verifica nombre, email y contraseña (mín 8 caracteres).');
            set_old($_POST);
            redirect('/admin/install');
        }
        $userId = User::create(['name' => $name, 'email' => $email, 'password' => $pass, 'role' => 'admin']);
        auth_login(['id' => $userId, 'email' => $email]);
        clear_old();
        flash('success', '¡Bienvenido! Tu admin está listo.');
        redirect('/admin');
    }

    public function loginForm(): void
    {
        Database::pdo();
        if (!Database::hasAdmin()) redirect('/admin/install');
        if (auth_check()) redirect('/admin');
        render_admin_bare('login', ['error' => flash('error')]);
    }

    public function login(): void
    {
        if (!csrf_check($_POST['_csrf'] ?? '')) {
            flash('error', 'Token de seguridad inválido. Recarga.');
            redirect('/admin/login');
        }
        $email = trim($_POST['email'] ?? '');
        $pass  = (string) ($_POST['password'] ?? '');
        $user = User::verifyLogin($email, $pass);
        if (!$user) {
            flash('error', 'Email o contraseña incorrectos.');
            set_old(['email' => $email]);
            redirect('/admin/login');
        }
        auth_login($user);
        clear_old();
        $intended = $_SESSION['_intended'] ?? '/admin';
        unset($_SESSION['_intended']);
        redirect($intended);
    }

    public function logout(): void
    {
        auth_logout();
        redirect('/admin/login');
    }

    /** Main dashboard */
    public function dashboard(): void
    {
        auth_require();
        $data = [
            'publishedProjects' => Project::count('published'),
            'publishedPosts'    => Post::count('published'),
            'drafts'            => Post::count('draft'),
            'categoriesCount'   => Category::count(),
            'recentPosts'       => array_slice(Post::allAdmin(), 0, 6),
            'recentProjects'    => array_slice(Project::allAdmin(), 0, 6),
            'newLeads'          => Lead::count('nuevo'),
            'recentLeads'       => array_slice(Lead::all(), 0, 5),
        ];
        render_admin('dashboard', $data, [
            'adminTitle' => 'Dashboard',
            'adminSubtitle' => 'Resumen del sitio',
        ]);
    }

    public function settings(): void
    {
        auth_require();
        $data = [
            'siteTitle'       => Setting::get('site_title', env('APP_NAME', 'KYROS Solutions')),
            'siteDescription' => Setting::get('site_description', 'Soluciones tecnológicas seguras e inteligentes.'),
            'contactEmail'    => Setting::get('contact_email', 'info@kyrosrd.com'),
            'contactPhone'    => Setting::get('contact_phone', '+1 (849) 502-4061'),
            'blogIntro'       => Setting::get('blog_intro', 'Ideas, casos y aprendizajes del equipo KYROS.'),
        ];
        render_admin('settings', $data, [
            'adminTitle' => 'Configuración',
            'adminSubtitle' => 'Ajustes globales del sitio',
        ]);
    }

    public function updateSettings(): void
    {
        auth_require();
        if (!csrf_check($_POST['_csrf'] ?? '')) {
            flash('error', 'Token inválido.');
            redirect('/admin/settings');
        }
        foreach (['site_title', 'site_description', 'contact_email', 'contact_phone', 'blog_intro'] as $k) {
            if (isset($_POST[$k])) Setting::set($k, trim((string) $_POST[$k]));
        }
        flash('success', 'Configuración guardada.');
        redirect('/admin/settings');
    }
}
