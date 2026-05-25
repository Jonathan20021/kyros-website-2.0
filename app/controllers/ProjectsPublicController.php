<?php
declare(strict_types=1);

class ProjectsPublicController
{
    public function index(): void
    {
        Database::pdo();
        $projects = Project::all('published');
        render_view('projects-public.index', [
            'projects' => $projects,
        ], [
            'title' => 'Proyectos · KYROS Solutions',
            'description' => 'Casos de estudio: software, ciberseguridad, infraestructura y soporte que mueven negocios.',
        ]);
    }

    public function show(string $slug): void
    {
        Database::pdo();
        $project = Project::findBySlug($slug);
        if (!$project || $project['status'] !== 'published') abort(404, 'Proyecto no encontrado');
        render_view('projects-public.single', [
            'project' => $project,
        ], [
            'title' => $project['title'] . ' · Proyecto · KYROS',
            'description' => $project['description'] ?: ('Caso de estudio: ' . $project['title']),
            'og_image' => $project['cover_image'] ?: url('assets/img/og-default.jpg'),
        ]);
    }
}
