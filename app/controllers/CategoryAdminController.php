<?php
declare(strict_types=1);

class CategoryAdminController
{
    public function index(): void
    {
        auth_require();
        render_admin('categories.index', [
            'categories' => Category::all(),
        ], [
            'adminTitle' => 'Categorías',
            'adminSubtitle' => 'Para organizar los posts del blog',
        ]);
    }

    public function store(): void
    {
        auth_require();
        if (!csrf_check($_POST['_csrf'] ?? '')) { flash('error', 'CSRF'); redirect('/admin/categories'); }
        $name = trim($_POST['name'] ?? '');
        if (!$name) { flash('error', 'Nombre requerido.'); redirect('/admin/categories'); }
        $slug = ensure_unique_slug('categories', slugify($name));
        Category::create([
            'name' => $name,
            'slug' => $slug,
            'description' => trim($_POST['description'] ?? '') ?: null,
            'color' => trim($_POST['color'] ?? '#F26522') ?: '#F26522',
            'sort_order' => (int)($_POST['sort_order'] ?? 0),
        ]);
        flash('success', 'Categoría creada.');
        redirect('/admin/categories');
    }

    public function update(string $id): void
    {
        auth_require();
        if (!csrf_check($_POST['_csrf'] ?? '')) { flash('error', 'CSRF'); redirect('/admin/categories'); }
        $cat = Category::find((int)$id);
        if (!$cat) { flash('error', 'No existe.'); redirect('/admin/categories'); }
        $name = trim($_POST['name'] ?? $cat['name']);
        $slug = trim($_POST['slug'] ?? $cat['slug']) ?: slugify($name);
        $slug = ensure_unique_slug('categories', slugify($slug), (int)$id);
        Category::update((int)$id, [
            'name' => $name,
            'slug' => $slug,
            'description' => trim($_POST['description'] ?? '') ?: null,
            'color' => trim($_POST['color'] ?? '#F26522') ?: '#F26522',
            'sort_order' => (int)($_POST['sort_order'] ?? 0),
        ]);
        flash('success', 'Categoría actualizada.');
        redirect('/admin/categories');
    }

    public function destroy(string $id): void
    {
        auth_require();
        if (!csrf_check($_POST['_csrf'] ?? '')) { flash('error', 'CSRF'); redirect('/admin/categories'); }
        Category::delete((int)$id);
        flash('success', 'Categoría eliminada.');
        redirect('/admin/categories');
    }

    /** AJAX endpoint: create category from the post editor modal. Returns JSON. */
    public function ajaxStore(): void
    {
        auth_require();
        header('Content-Type: application/json; charset=UTF-8');
        if (!csrf_check($_POST['_csrf'] ?? '')) {
            echo json_encode(['ok' => false, 'error' => 'CSRF']); return;
        }
        $name = trim($_POST['name'] ?? '');
        if (!$name) { echo json_encode(['ok' => false, 'error' => 'Nombre requerido']); return; }
        $slug = ensure_unique_slug('categories', slugify($name));
        try {
            $id = Category::create([
                'name'        => $name,
                'slug'        => $slug,
                'description' => trim($_POST['description'] ?? '') ?: null,
                'color'       => trim($_POST['color'] ?? '#F26522') ?: '#F26522',
                'sort_order'  => 0,
            ]);
            echo json_encode(['ok' => true, 'id' => $id, 'name' => $name, 'slug' => $slug, 'color' => $_POST['color'] ?? '#F26522']);
        } catch (Throwable $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }
}
