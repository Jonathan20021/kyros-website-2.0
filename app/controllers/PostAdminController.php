<?php
declare(strict_types=1);

class PostAdminController
{
    public function index(): void
    {
        auth_require();
        $action = '<a href="' . url('/admin/posts/new') . '" class="bg-[#F26522] hover:bg-[#E05A1A] text-white text-[13px] font-medium px-5 py-2.5 rounded-full transition">+ Nuevo post</a>';
        render_admin('posts.index', [
            'posts' => Post::allAdmin(),
        ], [
            'adminTitle' => 'Blog',
            'adminSubtitle' => 'Artículos del blog público',
            'adminAction' => $action,
        ]);
    }

    public function create(): void
    {
        auth_require();
        render_admin('posts.form', [
            'post' => null,
            'isEdit' => false,
            'categories' => Category::all(),
        ], [
            'adminTitle' => 'Nuevo post',
            'adminSubtitle' => 'Editor de artículos',
        ]);
    }

    public function store(): void
    {
        auth_require();
        if (!csrf_check($_POST['_csrf'] ?? '')) { flash('error', 'CSRF'); redirect('/admin/posts/new'); }
        $data = $this->collect();
        if (!$data['title']) {
            flash('error', 'Título obligatorio.');
            set_old($_POST);
            redirect('/admin/posts/new');
        }
        $data['slug'] = ensure_unique_slug('posts', slugify($data['slug'] ?: $data['title']));
        $data['author_id'] = auth_user()['id'] ?? null;
        $data['cover_image'] = $this->handleCover(null);
        $data['reading_time'] = $this->estimateReadingTime($data['content'] ?? '');
        try {
            $id = Post::create($data);
            clear_old();
            flash('success', 'Post creado.');
            redirect('/admin/posts/' . $id . '/edit');
        } catch (Throwable $e) {
            flash('error', 'Error: ' . $e->getMessage());
            set_old($_POST);
            redirect('/admin/posts/new');
        }
    }

    public function edit(string $id): void
    {
        auth_require();
        $post = Post::find((int)$id);
        if (!$post) { flash('error', 'No existe.'); redirect('/admin/posts'); }
        render_admin('posts.form', [
            'post' => $post,
            'isEdit' => true,
            'categories' => Category::all(),
        ], [
            'adminTitle' => 'Editar: ' . $post['title'],
            'adminSubtitle' => 'Edita o publica el post',
        ]);
    }

    public function update(string $id): void
    {
        auth_require();
        if (!csrf_check($_POST['_csrf'] ?? '')) { flash('error', 'CSRF'); redirect('/admin/posts/' . $id . '/edit'); }
        $post = Post::find((int)$id);
        if (!$post) { flash('error', 'No existe.'); redirect('/admin/posts'); }
        $data = $this->collect();
        $data['slug'] = ensure_unique_slug('posts', slugify($data['slug'] ?: $data['title']), (int)$id);
        $data['cover_image'] = $this->handleCover($post['cover_image'] ?? null);
        $data['reading_time'] = $this->estimateReadingTime($data['content'] ?? '');
        // If transitioning to published for the first time, stamp published_at
        if ($data['status'] === 'published' && empty($post['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }
        try {
            Post::update((int)$id, $data);
            flash('success', 'Post actualizado.');
            redirect('/admin/posts/' . $id . '/edit');
        } catch (Throwable $e) {
            flash('error', 'Error: ' . $e->getMessage());
            redirect('/admin/posts/' . $id . '/edit');
        }
    }

    public function destroy(string $id): void
    {
        auth_require();
        if (!csrf_check($_POST['_csrf'] ?? '')) { flash('error', 'CSRF'); redirect('/admin/posts'); }
        Post::delete((int)$id);
        flash('success', 'Post eliminado.');
        redirect('/admin/posts');
    }

    /* Helpers */

    private function collect(): array
    {
        return [
            'title'            => trim($_POST['title'] ?? ''),
            'slug'             => trim($_POST['slug'] ?? ''),
            'excerpt'          => trim($_POST['excerpt'] ?? '') ?: null,
            'content'          => $_POST['content'] ?? null,
            'category_id'      => (int)($_POST['category_id'] ?? 0) ?: null,
            'tags'             => trim($_POST['tags'] ?? '') ?: null,
            'status'           => ($_POST['status'] ?? 'draft') === 'published' ? 'published' : 'draft',
            'featured'         => !empty($_POST['featured']) ? 1 : 0,
            'meta_title'       => trim($_POST['meta_title'] ?? '') ?: null,
            'meta_description' => trim($_POST['meta_description'] ?? '') ?: null,
        ];
    }

    private function handleCover(?string $existing): ?string
    {
        if (!empty($_FILES['cover_file']['name'])) {
            $err = null;
            $url = upload_image($_FILES['cover_file'], $err);
            if ($url) return $url;
            if ($err) flash('error', $err);
        }
        $manualUrl = trim($_POST['cover_image_url'] ?? '');
        if ($manualUrl !== '') return $manualUrl;
        return $existing;
    }

    private function estimateReadingTime(?string $html): int
    {
        if (!$html) return 1;
        $words = str_word_count(strip_tags($html));
        return max(1, (int) ceil($words / 200));
    }
}
