<?php
declare(strict_types=1);

class BlogController
{
    public function index(): void
    {
        Database::pdo();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 9;
        $offset = ($page - 1) * $perPage;
        $posts = Post::published($perPage, $offset);
        $total = Post::countPublished();
        $totalPages = max(1, (int) ceil($total / $perPage));
        $categories = Category::all();

        render_view('blog.index', [
            'posts' => $posts,
            'page' => $page,
            'totalPages' => $totalPages,
            'categories' => $categories,
            'activeCategory' => null,
            'blogIntro' => Setting::get('blog_intro', 'Ideas, casos y aprendizajes del equipo KYROS.'),
        ], [
            'title' => 'Blog · KYROS Solutions',
            'description' => 'Artículos, casos y reflexiones sobre software, ciberseguridad, infraestructura y soporte IT.',
        ]);
    }

    public function byCategory(string $slug): void
    {
        Database::pdo();
        $category = Category::findBySlug($slug);
        if (!$category) abort(404, 'Categoría no encontrada');
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 9;
        $offset = ($page - 1) * $perPage;
        $posts = Post::published($perPage, $offset, (int)$category['id']);
        $total = Post::countPublished((int)$category['id']);
        $totalPages = max(1, (int) ceil($total / $perPage));

        render_view('blog.index', [
            'posts' => $posts,
            'page' => $page,
            'totalPages' => $totalPages,
            'categories' => Category::all(),
            'activeCategory' => $category,
            'blogIntro' => 'Artículos en ' . $category['name'],
        ], [
            'title' => $category['name'] . ' · Blog · KYROS Solutions',
            'description' => $category['description'] ?? ('Artículos sobre ' . $category['name']),
        ]);
    }

    public function show(string $slug): void
    {
        Database::pdo();
        $post = Post::findBySlug($slug);
        if (!$post || $post['status'] !== 'published') abort(404, 'Post no encontrado');
        Post::incrementViews((int)$post['id']);
        $related = Post::related((int)$post['id'], $post['category_id'] ? (int)$post['category_id'] : null, 3);

        render_view('blog.single', [
            'post' => $post,
            'related' => $related,
        ], [
            'title'       => ($post['meta_title'] ?: $post['title']) . ' · KYROS Blog',
            'description' => $post['meta_description'] ?: $post['excerpt'] ?: 'Lectura del blog KYROS',
            'og_image'    => $post['cover_image'] ?: url('assets/img/og-default.jpg'),
        ]);
    }
}
