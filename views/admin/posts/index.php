<!-- Top controls -->
<div class="flex flex-wrap items-center gap-3 mb-5">
    <div class="admin-search flex-1 min-w-[240px]">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: var(--ink-muted);"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="post-search" placeholder="Buscar por título, categoría o autor…">
    </div>
    <div class="flex items-center gap-2" id="post-filters">
        <button type="button" class="filter-pill is-active" data-filter="all">Todos</button>
        <button type="button" class="filter-pill" data-filter="published">Publicados</button>
        <button type="button" class="filter-pill" data-filter="draft">Borradores</button>
        <button type="button" class="filter-pill" data-filter="featured">⭐ Destacados</button>
    </div>
</div>

<div class="admin-card p-0 overflow-hidden">
    <div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th></th>
                <th>Título</th>
                <th>Categoría</th>
                <th>Autor</th>
                <th>Vistas</th>
                <th>Estado</th>
                <th>Publicado</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="post-tbody">
            <?php if (empty($posts)): ?>
                <tr><td colspan="8" class="text-center py-12">
                    <p class="mb-3" style="color: var(--ink-muted);">Aún no hay posts. Empieza tu blog.</p>
                    <a href="<?= url('/admin/posts/new') ?>" class="btn-admin-primary">+ Nuevo post</a>
                </td></tr>
            <?php else: foreach ($posts as $p): ?>
                <tr data-status="<?= e($p['status']) ?>" data-featured="<?= (int)$p['featured'] ?>" data-search="<?= e(strtolower(($p['title'] ?? '') . ' ' . ($p['category_name'] ?? '') . ' ' . ($p['author_name'] ?? ''))) ?>">
                    <td style="width: 56px;">
                        <?php if (!empty($p['cover_image'])): ?>
                            <img src="<?= e($p['cover_image']) ?>" alt="" class="w-10 h-10 rounded-lg object-cover">
                        <?php else: ?>
                            <div class="w-10 h-10 rounded-lg bg-stone-100 flex items-center justify-center" style="color: var(--ink-muted);"><?= icon('message', 'w-4 h-4') ?></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= url('/admin/posts/' . $p['id'] . '/edit') ?>" class="font-medium hover:text-[#F26522] transition-colors" style="color: var(--ink);"><?= e($p['title']) ?></a>
                        <?php if (!empty($p['featured'])): ?><span class="ml-2 text-[#F26522]">★</span><?php endif; ?>
                        <div class="text-[12px] mt-0.5"><code class="px-1.5 py-0.5 bg-stone-100 rounded text-[11px]"><?= e($p['slug']) ?></code></div>
                    </td>
                    <td>
                        <?php if (!empty($p['category_name'])): ?>
                            <span class="text-[12px] px-2 py-1 rounded-full font-medium" style="background: <?= e($p['category_color'] ?? '#F26522') ?>15; color: <?= e($p['category_color'] ?? '#F26522') ?>;"><?= e($p['category_name']) ?></span>
                        <?php else: ?>
                            <span style="color:var(--ink-muted);">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-[13px]"><?= e($p['author_name'] ?? '—') ?></td>
                    <td class="text-[13px]"><?= (int)$p['views'] ?></td>
                    <td><span class="badge-status badge-status--<?= e($p['status']) ?>"><?= e($p['status']) ?></span></td>
                    <td class="text-[12px]" style="color: var(--ink-muted);">
                        <?= !empty($p['published_at']) ? e(date('d M Y', strtotime($p['published_at']))) : '—' ?>
                    </td>
                    <td class="text-right">
                        <?php if (($p['status'] ?? '') === 'published'): ?>
                            <a href="<?= url('/blog/' . $p['slug']) ?>" target="_blank" class="text-[12px] mr-3" style="color: var(--ink-muted);">Ver ↗</a>
                        <?php endif; ?>
                        <a href="<?= url('/admin/posts/' . $p['id'] . '/edit') ?>" class="text-[13px] font-medium hover:text-[#F26522]" style="color: var(--ink);">Editar</a>
                        <button type="button"
                                data-modal-open="modal-confirm-delete"
                                data-confirm-title="<?= e($p['title']) ?>"
                                data-confirm-action="<?= url('/admin/posts/' . $p['id'] . '/delete') ?>"
                                class="text-[13px] text-red-600 hover:underline ml-3">Borrar</button>
                    </td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
    </div>
</div>

<script>
(() => {
    const search = document.getElementById('post-search');
    const filters = document.getElementById('post-filters');
    const tbody = document.getElementById('post-tbody');
    if (!tbody) return;
    let activeFilter = 'all';
    const apply = () => {
        const q = (search.value || '').toLowerCase().trim();
        tbody.querySelectorAll('tr[data-search]').forEach(tr => {
            const matchesQ = !q || tr.dataset.search.includes(q);
            const matchesF = activeFilter === 'all'
                || (activeFilter === 'featured' ? tr.dataset.featured === '1' : tr.dataset.status === activeFilter);
            tr.style.display = (matchesQ && matchesF) ? '' : 'none';
        });
    };
    search?.addEventListener('input', apply);
    filters?.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-filter]');
        if (!btn) return;
        filters.querySelectorAll('.filter-pill').forEach(b => b.classList.remove('is-active'));
        btn.classList.add('is-active');
        activeFilter = btn.dataset.filter;
        apply();
    });
})();
</script>
