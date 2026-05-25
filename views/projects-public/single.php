<?php require_once base_path('views/partials/icons.php'); $p = $project; ?>

<article class="bg-white pt-28 sm:pt-36 pb-16 sm:pb-20">
    <div class="max-w-[1000px] mx-auto px-5 sm:px-8 lg:px-12">

        <div class="flex items-center gap-3 mb-6 text-[13px]" style="color: var(--ink-muted);">
            <a href="<?= url('/proyectos') ?>" class="hover:text-[#F26522]">← Proyectos</a>
            <?php if (!empty($p['category'])): ?>
                <span>·</span><span class="font-medium" style="color: var(--ink);"><?= e($p['category']) ?></span>
            <?php endif; ?>
        </div>

        <div class="grid lg:grid-cols-[1fr_280px] gap-8 mb-10">
            <div>
                <h1 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance mb-5"
                    style="color: var(--ink); font-size: clamp(2rem, 5vw, 3.5rem);">
                    <?= e($p['title']) ?>
                </h1>
                <?php if (!empty($p['description'])): ?>
                    <p class="text-[17px] sm:text-[19px] leading-[1.5]" style="color: var(--ink-soft);">
                        <?= e($p['description']) ?>
                    </p>
                <?php endif; ?>
            </div>

            <aside class="lg:border-l lg:pl-8 border-[rgba(17,17,17,0.10)] space-y-4 text-[13px]">
                <?php if (!empty($p['client'])): ?>
                    <div>
                        <div class="text-[11px] font-mono uppercase tracking-[0.16em] mb-1" style="color: var(--ink-muted);">Cliente</div>
                        <div class="font-medium" style="color: var(--ink);"><?= e($p['client']) ?></div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($p['year'])): ?>
                    <div>
                        <div class="text-[11px] font-mono uppercase tracking-[0.16em] mb-1" style="color: var(--ink-muted);">Año</div>
                        <div class="font-medium" style="color: var(--ink);"><?= e($p['year']) ?></div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($p['metric'])): ?>
                    <div>
                        <div class="text-[11px] font-mono uppercase tracking-[0.16em] mb-1" style="color: var(--ink-muted);">Resultado</div>
                        <div class="font-medium" style="color: #F26522;"><?= e($p['metric']) ?></div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($p['tags'])): ?>
                    <div>
                        <div class="text-[11px] font-mono uppercase tracking-[0.16em] mb-2" style="color: var(--ink-muted);">Tags</div>
                        <div class="flex flex-wrap gap-1.5">
                            <?php foreach (array_map('trim', explode(',', $p['tags'])) as $tag): if ($tag): ?>
                                <span class="px-2 py-1 rounded bg-gray-100 text-[11px] font-medium" style="color: var(--ink-soft);">#<?= e($tag) ?></span>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($p['external_url'])): ?>
                    <a href="<?= e($p['external_url']) ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-[#F26522] font-medium hover:underline">
                        Visitar sitio →
                    </a>
                <?php endif; ?>
            </aside>
        </div>

        <?php if (!empty($p['cover_image'])): ?>
            <img src="<?= e($p['cover_image']) ?>" alt="<?= e($p['title']) ?>" class="w-full rounded-2xl mb-10 object-cover" style="max-height: 540px;">
        <?php endif; ?>

        <div class="prose-blog">
            <?= $p['content'] ?? '<p>Detalle del proyecto próximamente.</p>' ?>
        </div>
    </div>
</article>

<section class="bg-[#EFEFEF] py-14 relative overflow-hidden">
    <div class="hero-canvas" aria-hidden="true">
        <div class="hero-canvas__chroma"></div>
        <div class="hero-canvas__grain"></div>
    </div>
    <div class="relative z-10 max-w-[1000px] mx-auto px-5 sm:px-8 text-center">
        <h3 class="font-medium text-[clamp(1.5rem,3vw,2.25rem)] tracking-tight leading-tight mb-5" style="color: var(--ink);">
            ¿Tienes un proyecto similar?
        </h3>
        <a href="<?= url('/contact') ?>" class="btn-orange group inline-flex">
            <span class="text-roll">
                <span class="text-roll__inner">
                    <span>Hablemos</span><span>Hablemos</span>
                </span>
            </span>
            <span class="arrow-circle arrow-circle__orange">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
            </span>
        </a>
    </div>
</section>

<style>
    .prose-blog { color: var(--ink); font-size: 17px; line-height: 1.75; }
    .prose-blog h2, .prose-blog h3 { color: var(--ink); margin: 2em 0 0.75em; font-weight: 600; letter-spacing: -0.02em; }
    .prose-blog h2 { font-size: 1.7rem; }
    .prose-blog h3 { font-size: 1.3rem; }
    .prose-blog p { margin: 0 0 1.25em; }
    .prose-blog a { color: #F26522; text-decoration: underline; }
    .prose-blog ul, .prose-blog ol { margin: 0 0 1.5em 1.5em; }
    .prose-blog li { margin-bottom: 0.5em; }
    .prose-blog img { border-radius: 12px; margin: 1.5em 0; max-width: 100%; height: auto; }
</style>
