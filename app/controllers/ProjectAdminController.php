<?php
declare(strict_types=1);

class ProjectAdminController
{
    public function index(): void
    {
        auth_require();
        $action = '<a href="' . url('/admin/projects/new') . '" class="bg-[#F26522] hover:bg-[#E05A1A] text-white text-[13px] font-medium px-5 py-2.5 rounded-full transition">+ Nuevo proyecto</a>';
        render_admin('projects.index', [
            'projects' => Project::allAdmin(),
        ], [
            'adminTitle'    => 'Proyectos',
            'adminSubtitle' => 'Casos de estudio que aparecen en la landing',
            'adminAction'   => $action,
        ]);
    }

    public function create(): void
    {
        auth_require();
        render_admin('projects.form', [
            'project'    => null,
            'isEdit'     => false,
            'categories' => Project::distinctCategories(),
            'tagSuggest' => Project::distinctTags(),
        ], [
            'adminTitle'    => 'Nuevo proyecto',
            'adminSubtitle' => 'Crea un nuevo caso de estudio',
        ]);
    }

    public function store(): void
    {
        auth_require();
        if (!csrf_check($_POST['_csrf'] ?? '')) { flash('error', 'CSRF'); redirect('/admin/projects/new'); }
        $data = $this->collect();
        if (!$data['title']) {
            flash('error', 'El título es obligatorio.');
            set_old($_POST);
            redirect('/admin/projects/new');
        }
        $data['slug'] = ensure_unique_slug('projects', slugify($data['slug'] ?: $data['title']));
        $data['cover_image'] = $this->handleCover($data['cover_image'] ?? null);
        try {
            $id = Project::create($data);
            clear_old();
            flash('success', 'Proyecto creado.');
            redirect('/admin/projects/' . $id . '/edit');
        } catch (Throwable $e) {
            flash('error', 'Error al guardar: ' . $e->getMessage());
            set_old($_POST);
            redirect('/admin/projects/new');
        }
    }

    public function edit(string $id): void
    {
        auth_require();
        $project = Project::find((int) $id);
        if (!$project) { flash('error', 'No existe.'); redirect('/admin/projects'); }
        render_admin('projects.form', [
            'project'    => $project,
            'isEdit'     => true,
            'categories' => Project::distinctCategories(),
            'tagSuggest' => Project::distinctTags(),
        ], [
            'adminTitle'    => 'Editar: ' . $project['title'],
            'adminSubtitle' => 'Actualiza información, imagen y estado',
        ]);
    }

    public function update(string $id): void
    {
        auth_require();
        if (!csrf_check($_POST['_csrf'] ?? '')) { flash('error', 'CSRF'); redirect('/admin/projects/' . $id . '/edit'); }
        $project = Project::find((int) $id);
        if (!$project) { flash('error', 'No existe.'); redirect('/admin/projects'); }
        $data = $this->collect();
        $data['slug'] = ensure_unique_slug('projects', slugify($data['slug'] ?: $data['title']), (int)$id);
        $data['cover_image'] = $this->handleCover($project['cover_image'] ?? null);
        try {
            Project::update((int)$id, $data);
            flash('success', 'Proyecto actualizado.');
            redirect('/admin/projects/' . $id . '/edit');
        } catch (Throwable $e) {
            flash('error', 'Error: ' . $e->getMessage());
            redirect('/admin/projects/' . $id . '/edit');
        }
    }

    public function destroy(string $id): void
    {
        auth_require();
        if (!csrf_check($_POST['_csrf'] ?? '')) { flash('error', 'CSRF'); redirect('/admin/projects'); }
        Project::delete((int)$id);
        flash('success', 'Proyecto eliminado.');
        redirect('/admin/projects');
    }

    /* ── Helpers ─────────────────────────────────────── */

    private function collect(): array
    {
        return [
            'title'        => trim($_POST['title'] ?? ''),
            'slug'         => trim($_POST['slug'] ?? ''),
            'client'       => trim($_POST['client'] ?? '') ?: null,
            'category'     => trim($_POST['category'] ?? '') ?: null,
            'description'  => trim($_POST['description'] ?? '') ?: null,
            'content'      => $_POST['content'] ?? null,
            'cover_image'  => $_POST['cover_image_url'] ?? null,
            'tags'         => trim($_POST['tags'] ?? '') ?: null,
            'metric'       => trim($_POST['metric'] ?? '') ?: null,
            'external_url' => trim($_POST['external_url'] ?? '') ?: null,
            'year'         => trim($_POST['year'] ?? '') ?: null,
            'color_theme'  => trim($_POST['color_theme'] ?? 'dark') ?: 'dark',
            'status'       => ($_POST['status'] ?? 'published') === 'draft' ? 'draft' : 'published',
            'featured'     => !empty($_POST['featured']) ? 1 : 0,
            'sort_order'   => (int)($_POST['sort_order'] ?? 0),
        ];
    }

    /** If a new file is uploaded use it, otherwise keep $existing (or URL pasted). */
    private function handleCover(?string $existing): ?string
    {
        if (!empty($_FILES['cover_file']['name'])) {
            $err = null;
            $url = upload_image($_FILES['cover_file'], $err);
            if ($url) return $url;
            if ($err) flash('error', $err);
        }
        // Manual URL field overrides existing
        $manualUrl = trim($_POST['cover_image_url'] ?? '');
        if ($manualUrl !== '') return $manualUrl;
        return $existing;
    }
}
