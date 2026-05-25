<?php require_once base_path('views/partials/icons.php'); ?>

<article class="bg-white pt-28 sm:pt-36 pb-16 sm:pb-20">
    <div class="max-w-[820px] mx-auto px-5 sm:px-8">

        <!-- Breadcrumb / meta -->
        <div class="flex items-center gap-3 mb-6 text-[13px]" style="color: var(--ink-muted);">
            <a href="<?= url('/blog') ?>" class="hover:text-[#F26522]">← Blog</a>
            <?php if (!empty($post['category_name'])): ?>
                <span>·</span>
                <a href="<?= url('/blog/categoria/' . $post['category_slug']) ?>" class="font-medium" style="color: <?= e($post['category_color'] ?? '#F26522') ?>;"><?= e($post['category_name']) ?></a>
            <?php endif; ?>
        </div>

        <h1 class="font-medium leading-[1.08] tracking-[-0.03em] text-balance mb-6"
            style="color: var(--ink); font-size: clamp(2rem, 5vw, 3.5rem);">
            <?= e($post['title']) ?>
        </h1>

        <?php if (!empty($post['excerpt'])): ?>
            <p class="text-[18px] sm:text-[20px] leading-[1.5] mb-8 font-medium" style="color: var(--ink-soft);">
                <?= e($post['excerpt']) ?>
            </p>
        <?php endif; ?>

        <!-- Meta line -->
        <div class="flex items-center gap-3 pb-8 mb-10 border-b border-[rgba(17,17,17,0.08)]">
            <div class="w-10 h-10 rounded-full bg-[#F26522] text-white flex items-center justify-center font-semibold text-[14px]">
                <?= e(strtoupper(substr($post['author_name'] ?? 'K', 0, 1))) ?>
            </div>
            <div class="flex-1">
                <div class="text-[14px] font-medium" style="color: var(--ink);"><?= e($post['author_name'] ?? 'KYROS Solutions') ?></div>
                <div class="text-[12px]" style="color: var(--ink-muted);">
                    <?= e(date('d \d\e F, Y', strtotime($post['published_at'] ?? $post['created_at']))) ?>
                    · <?= (int)$post['reading_time'] ?> min de lectura
                    · <?= (int)$post['views'] ?> vistas
                </div>
            </div>
        </div>

        <?php if (!empty($post['cover_image'])): ?>
            <img src="<?= e($post['cover_image']) ?>" alt="<?= e($post['title']) ?>" class="w-full rounded-2xl mb-10 object-cover" style="max-height: 480px;">
        <?php endif; ?>

        <!-- Rich content (Quill HTML) -->
        <div class="prose-blog">
            <?= $post['content'] ?? '' ?>
        </div>

        <!-- Share / tags -->
        <?php if (!empty($post['tags'])): ?>
            <div class="mt-12 pt-8 border-t border-[rgba(17,17,17,0.08)] flex flex-wrap gap-2">
                <?php foreach (array_map('trim', explode(',', $post['tags'])) as $tag): if ($tag): ?>
                    <span class="px-3 py-1 rounded-full bg-gray-100 text-[12px] font-medium" style="color: var(--ink-soft);">#<?= e($tag) ?></span>
                <?php endif; endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Author card -->
        <?php if (!empty($post['author_name'])): ?>
            <div class="mt-12 p-6 rounded-2xl bg-[#FAFAFA] border border-[rgba(17,17,17,0.06)] flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-[#F26522] text-white flex items-center justify-center font-semibold text-[18px]">
                    <?= e(strtoupper(substr($post['author_name'], 0, 1))) ?>
                </div>
                <div>
                    <div class="font-medium text-[15px]" style="color: var(--ink);"><?= e($post['author_name']) ?></div>
                    <div class="text-[13px]" style="color: var(--ink-muted);">
                        <?= e($post['author_bio'] ?? 'Equipo KYROS Solutions') ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</article>

<!-- Related posts -->
<?php if (!empty($related)): ?>
    <section class="bg-[#F5F5F5] py-16 sm:py-20">
        <div class="max-w-[1200px] mx-auto px-5 sm:px-8 lg:px-12">
            <h2 class="font-medium leading-tight tracking-tight mb-10" style="color: var(--ink); font-size: clamp(1.5rem, 3vw, 2.25rem);">
                También te puede interesar
            </h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                <?php foreach ($related as $rp): ?>
                    <a href="<?= url('/blog/' . $rp['slug']) ?>" class="group">
                        <div class="rounded-2xl overflow-hidden bg-gray-100 mb-4" style="aspect-ratio: 16/10;">
                            <?php if (!empty($rp['cover_image'])): ?>
                                <img src="<?= e($rp['cover_image']) ?>" alt="" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <?php else: ?>
                                <div class="w-full h-full" style="background: linear-gradient(135deg, <?= e($rp['category_color'] ?? '#F26522') ?>22, transparent);"></div>
                            <?php endif; ?>
                        </div>
                        <h3 class="font-medium text-[18px] tracking-tight leading-tight group-hover:text-[#F26522] transition-colors" style="color: var(--ink);">
                            <?= e($rp['title']) ?>
                        </h3>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<style>
    .prose-blog { color: var(--ink); font-size: 17px; line-height: 1.75; }
    .prose-blog h1, .prose-blog h2, .prose-blog h3 { color: var(--ink); margin: 2.5em 0 0.75em; font-weight: 600; letter-spacing: -0.02em; }
    .prose-blog h1 { font-size: 2rem; }
    .prose-blog h2 { font-size: 1.6rem; }
    .prose-blog h3 { font-size: 1.3rem; }
    .prose-blog p { margin: 0 0 1.25em; }
    .prose-blog a { color: #F26522; text-decoration: underline; text-underline-offset: 3px; }
    .prose-blog ul, .prose-blog ol { margin: 0 0 1.5em 1.5em; }
    .prose-blog li { margin-bottom: 0.5em; }
    .prose-blog blockquote {
        margin: 1.5em 0; padding: 1em 1.5em;
        border-left: 4px solid #F26522;
        background: #FFF7F0;
        border-radius: 0 12px 12px 0;
        font-style: italic;
    }
    .prose-blog code {
        background: #F5F5F5;
        padding: 0.15em 0.4em;
        border-radius: 4px;
        font-size: 0.9em;
        font-family: 'Geist Mono', monospace;
    }
    .prose-blog pre {
        background: #111;
        color: #fff;
        padding: 1.25em;
        border-radius: 12px;
        overflow-x: auto;
        margin: 1.5em 0;
        font-size: 14px;
    }
    .prose-blog pre code { background: transparent; color: inherit; padding: 0; }
    .prose-blog img { border-radius: 12px; margin: 1.5em 0; max-width: 100%; height: auto; }
    .prose-blog hr { border: 0; border-top: 1px solid rgba(17,17,17,0.10); margin: 2em 0; }
</style>
