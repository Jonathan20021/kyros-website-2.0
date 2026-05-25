<?php require_once base_path('views/partials/icons.php'); ?>

<!-- Hero strip with animated bg -->
<section class="relative pt-32 sm:pt-36 pb-16 sm:pb-20 overflow-hidden bg-[#EFEFEF]">
    <div class="hero-canvas" aria-hidden="true">
        <div class="hero-canvas__chroma"></div>
        <div class="hero-canvas__fluted"></div>
        <div class="hero-canvas__grain"></div>
    </div>

    <div class="relative z-20 max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="section-badge mb-6">
            <span class="section-badge__num">B</span>
            <span class="section-badge__label">Blog · KYROS</span>
        </div>
        <h1 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
            style="color: var(--ink); font-size: clamp(2rem, 6vw, 4rem);">
            <?php if ($activeCategory): ?>
                Categoría:<br>
                <span style="color: <?= e($activeCategory['color']) ?>;"><?= e($activeCategory['name']) ?></span>
            <?php else: ?>
                Ideas, casos y aprendizajes.
            <?php endif; ?>
        </h1>
        <p class="mt-6 max-w-2xl text-[16px] sm:text-[17px] leading-[1.6]" style="color: var(--ink-soft);">
            <?= e($blogIntro) ?>
        </p>

        <?php if (!empty($categories)): ?>
            <div class="mt-8 flex flex-wrap gap-2">
                <a href="<?= url('/blog') ?>" class="px-4 py-2 rounded-full text-[13px] font-medium border <?= !$activeCategory ? 'bg-[#111] text-white border-[#111]' : 'bg-white border-[rgba(17,17,17,0.10)] hover:border-[#F26522]' ?>">Todas</a>
                <?php foreach ($categories as $c): ?>
                    <a href="<?= url('/blog/categoria/' . $c['slug']) ?>"
                       class="px-4 py-2 rounded-full text-[13px] font-medium border <?= ($activeCategory && $activeCategory['id'] === $c['id']) ? 'text-white' : 'bg-white border-[rgba(17,17,17,0.10)] hover:border-[#F26522]' ?>"
                       <?= ($activeCategory && $activeCategory['id'] === $c['id']) ? 'style="background:' . e($c['color']) . '; border-color:' . e($c['color']) . ';"' : '' ?>>
                        <?= e($c['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Posts grid -->
<section class="bg-white py-16 sm:py-20">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">

        <?php if (empty($posts)): ?>
            <div class="text-center py-20">
                <p class="text-[18px]" style="color: var(--ink-muted);">Aún no hay posts publicados. Vuelve pronto.</p>
            </div>
        <?php else: ?>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7" data-fluid-stagger>
                <?php foreach ($posts as $post): ?>
                    <a href="<?= url('/blog/' . $post['slug']) ?>" class="group">
                        <div class="rounded-2xl overflow-hidden bg-gray-100 mb-4" style="aspect-ratio: 16/10;">
                            <?php if (!empty($post['cover_image'])): ?>
                                <img src="<?= e($post['cover_image']) ?>" alt="<?= e($post['title']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <?php else: ?>
                                <div class="w-full h-full" style="background: linear-gradient(135deg, <?= e($post['category_color'] ?? '#F26522') ?>22, transparent);"></div>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center gap-2 mb-3">
                            <?php if (!empty($post['category_name'])): ?>
                                <span class="text-[11px] font-medium uppercase tracking-[0.10em] px-2.5 py-1 rounded-full" style="background: <?= e($post['category_color'] ?? '#F26522') ?>15; color: <?= e($post['category_color'] ?? '#F26522') ?>;">
                                    <?= e($post['category_name']) ?>
                                </span>
                            <?php endif; ?>
                            <span class="text-[12px]" style="color: var(--ink-muted);"><?= (int)$post['reading_time'] ?> min lectura</span>
                        </div>
                        <h2 class="font-medium text-[20px] sm:text-[22px] tracking-tight leading-tight mb-2 group-hover:text-[#F26522] transition-colors" style="color: var(--ink);">
                            <?= e($post['title']) ?>
                        </h2>
                        <?php if (!empty($post['excerpt'])): ?>
                            <p class="text-[14.5px] leading-relaxed line-clamp-3" style="color: var(--ink-muted);"><?= e($post['excerpt']) ?></p>
                        <?php endif; ?>
                        <div class="mt-4 text-[12px]" style="color: var(--ink-muted);">
                            <?= e(date('d M Y', strtotime($post['published_at'] ?? $post['created_at']))) ?>
                            <?php if (!empty($post['author_name'])): ?> · <?= e($post['author_name']) ?><?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <?php if ($totalPages > 1): ?>
                <div class="mt-16 flex items-center justify-center gap-2">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="<?= url('/blog?page=' . $i) ?>"
                           class="w-10 h-10 inline-flex items-center justify-center rounded-full text-[13px] font-medium <?= $i === $page ? 'bg-[#111] text-white' : 'bg-white border border-[rgba(17,17,17,0.10)] hover:border-[#F26522]' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
