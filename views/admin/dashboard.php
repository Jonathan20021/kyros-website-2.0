<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8" data-fluid-stagger>
    <?php
    $stats = [
        ['Solicitudes nuevas',   $newLeads ?? 0,     'message',   '#F26522', url('/admin/leads?status=nuevo')],
        ['Proyectos publicados', $publishedProjects, 'briefcase', '#4F46E5', url('/admin/projects')],
        ['Posts publicados',     $publishedPosts,    'palette',   '#7C3AED', url('/admin/posts')],
        ['Categorías',           $categoriesCount,   'layers',    '#06B6D4', url('/admin/categories')],
    ];
    foreach ($stats as [$lbl, $val, $ic, $col, $href]):
    ?>
        <a href="<?= e($href) ?>" class="admin-card hover:shadow-[0_8px_24px_rgba(0,0,0,0.06)] hover:border-[rgba(17,17,17,0.12)] block">
            <div class="flex items-start justify-between mb-4">
                <span class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: <?= $col ?>15; color: <?= $col ?>;">
                    <?= icon($ic, 'w-4 h-4') ?>
                </span>
                <span class="text-[11px] uppercase tracking-[0.10em]" style="color: var(--ink-muted);"><?= e($lbl) ?></span>
            </div>
            <div class="text-[36px] font-medium tracking-[-0.03em] leading-none" style="color: var(--ink);">
                <span data-counter="<?= (int)$val ?>"><?= number_format((int)$val) ?></span>
            </div>
            <div class="mt-3 text-[12px]" style="color: var(--ink-muted);">Ver detalle →</div>
        </a>
    <?php endforeach; ?>
</div>

<!-- Recent leads -->
<div class="admin-card mb-5">
    <div class="flex items-center justify-between mb-5">
        <h2 class="font-medium text-[16px]" style="color: var(--ink);">Últimas solicitudes</h2>
        <a href="<?= url('/admin/leads') ?>" class="text-[12px] font-medium text-[#F26522] hover:underline">Ver todas →</a>
    </div>
    <?php if (empty($recentLeads)): ?>
        <p class="text-[14px]" style="color: var(--ink-muted);">Aún no hay solicitudes desde "Hablemos del proyecto".</p>
    <?php else: ?>
        <ul class="space-y-1">
            <?php foreach ($recentLeads as $l): ?>
                <li class="flex items-center gap-3 py-2.5 border-b border-[rgba(17,17,17,0.04)] last:border-0">
                    <span class="lead-badge lead-badge--<?= e($l['status']) ?>"><?= e($l['status']) ?></span>
                    <div class="flex-1 min-w-0">
                        <a href="<?= url('/admin/leads/' . $l['id']) ?>" class="text-[14px] font-medium truncate block hover:text-[#F26522]" style="color: var(--ink);">
                            <?= e($l['name']) ?><?= $l['company'] ? ' · ' . e($l['company']) : '' ?>
                        </a>
                        <span class="text-[12px]" style="color: var(--ink-muted);"><?= e($l['ref']) ?></span>
                    </div>
                    <span class="text-[12px] flex-shrink-0" style="color: var(--ink-muted);"><?= e(date('d/m/Y', strtotime((string) $l['created_at']))) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<div class="grid lg:grid-cols-2 gap-5" data-fluid-stagger>
    <!-- Recent posts -->
    <div class="admin-card">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-medium text-[16px]" style="color: var(--ink);">Posts recientes</h2>
            <a href="<?= url('/admin/posts/new') ?>" class="text-[12px] font-medium text-[#F26522] hover:underline">+ Nuevo post</a>
        </div>
        <?php if (empty($recentPosts)): ?>
            <p class="text-[14px]" style="color: var(--ink-muted);">Aún no hay posts. Crea el primero.</p>
        <?php else: ?>
            <ul class="space-y-3">
                <?php foreach ($recentPosts as $p): ?>
                    <li class="flex items-center gap-3 py-2 border-b border-[rgba(17,17,17,0.04)] last:border-0">
                        <div class="flex-1 min-w-0">
                            <a href="<?= url('/admin/posts/' . $p['id'] . '/edit') ?>" class="text-[14px] font-medium truncate block hover:text-[#F26522]" style="color: var(--ink);"><?= e($p['title']) ?></a>
                            <div class="text-[11px] mt-0.5" style="color: var(--ink-muted);">
                                <?= e($p['status']) ?> · <?= e(date('d M Y', strtotime($p['created_at']))) ?>
                            </div>
                        </div>
                        <span class="badge-status badge-status--<?= e($p['status']) ?>"><?= e($p['status']) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- Recent projects -->
    <div class="admin-card">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-medium text-[16px]" style="color: var(--ink);">Proyectos recientes</h2>
            <a href="<?= url('/admin/projects/new') ?>" class="text-[12px] font-medium text-[#F26522] hover:underline">+ Nuevo proyecto</a>
        </div>
        <?php if (empty($recentProjects)): ?>
            <p class="text-[14px]" style="color: var(--ink-muted);">Aún no hay proyectos. Crea el primero.</p>
        <?php else: ?>
            <ul class="space-y-3">
                <?php foreach ($recentProjects as $p): ?>
                    <li class="flex items-center gap-3 py-2 border-b border-[rgba(17,17,17,0.04)] last:border-0">
                        <?php if (!empty($p['cover_image'])): ?>
                            <img src="<?= e($p['cover_image']) ?>" alt="" class="w-12 h-12 rounded-lg object-cover">
                        <?php else: ?>
                            <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center" style="color: var(--ink-muted);"><?= icon('briefcase', 'w-5 h-5') ?></div>
                        <?php endif; ?>
                        <div class="flex-1 min-w-0">
                            <a href="<?= url('/admin/projects/' . $p['id'] . '/edit') ?>" class="text-[14px] font-medium truncate block hover:text-[#F26522]" style="color: var(--ink);"><?= e($p['title']) ?></a>
                            <div class="text-[11px] mt-0.5" style="color: var(--ink-muted);"><?= e($p['client'] ?? '—') ?></div>
                        </div>
                        <?php if ($p['featured']): ?>
                            <span class="text-[10px] px-2 py-1 rounded bg-[#FEF3C7] text-[#92400E] font-semibold">★</span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<!-- Quick actions -->
<div class="admin-card mt-5">
    <h2 class="font-medium text-[16px] mb-5" style="color: var(--ink);">Accesos rápidos</h2>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3" data-fluid-stagger>
        <a href="<?= url('/admin/projects/new') ?>" class="flex items-center gap-3 p-4 rounded-xl border border-[rgba(17,17,17,0.06)] hover:border-[#F26522] hover:bg-[#FFFBF8] transition-all">
            <span class="w-8 h-8 rounded-lg bg-[#FFF4ED] text-[#F26522] flex items-center justify-center"><?= icon('briefcase', 'w-4 h-4') ?></span>
            <span class="text-[13px] font-medium" style="color: var(--ink);">Nuevo proyecto</span>
        </a>
        <a href="<?= url('/admin/posts/new') ?>" class="flex items-center gap-3 p-4 rounded-xl border border-[rgba(17,17,17,0.06)] hover:border-[#F26522] hover:bg-[#FFFBF8] transition-all">
            <span class="w-8 h-8 rounded-lg bg-[#EEF2FF] text-[#4F46E5] flex items-center justify-center"><?= icon('message', 'w-4 h-4') ?></span>
            <span class="text-[13px] font-medium" style="color: var(--ink);">Nuevo post</span>
        </a>
        <a href="<?= url('/admin/categories') ?>" class="flex items-center gap-3 p-4 rounded-xl border border-[rgba(17,17,17,0.06)] hover:border-[#F26522] hover:bg-[#FFFBF8] transition-all">
            <span class="w-8 h-8 rounded-lg bg-[#ECFEFF] text-[#06B6D4] flex items-center justify-center"><?= icon('layers', 'w-4 h-4') ?></span>
            <span class="text-[13px] font-medium" style="color: var(--ink);">Categorías</span>
        </a>
        <a href="<?= url('/') ?>" target="_blank" class="flex items-center gap-3 p-4 rounded-xl border border-[rgba(17,17,17,0.06)] hover:border-[#F26522] hover:bg-[#FFFBF8] transition-all">
            <span class="w-8 h-8 rounded-lg bg-[#F5F3FF] text-[#7C3AED] flex items-center justify-center"><?= icon('globe', 'w-4 h-4') ?></span>
            <span class="text-[13px] font-medium" style="color: var(--ink);">Ver sitio público</span>
        </a>
    </div>
</div>
