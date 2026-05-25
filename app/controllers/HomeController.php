<?php
declare(strict_types=1);

class HomeController
{
    public function index(): void
    {
        // Try DB; track whether the query actually succeeded (vs DB-down)
        $projects = [];
        $dbReachable = false;
        try {
            $projects = Project::all('published', 4, true);
            if (empty($projects)) {
                $projects = Project::all('published', 4, false);
            }
            $dbReachable = true; // query worked even if it returned 0 rows
        } catch (Throwable $e) {
            $projects = [];
            $dbReachable = false;
        }

        $recentPosts = [];
        try {
            $recentPosts = Post::published(3, 0);
        } catch (Throwable $e) { $recentPosts = []; }

        render_view('home', compact('projects', 'recentPosts', 'dbReachable'), [
            'title'       => 'KYROS Solutions · Tecnología que funciona como debe',
            'description' => 'Desarrollo de software a medida, ciberseguridad avanzada, soporte IT 24/7 e infraestructura de redes para empresas que no pueden permitirse fallar.',
            'page_key'    => 'home',
        ]);
    }
}
