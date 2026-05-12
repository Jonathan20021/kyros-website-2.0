<?php require_once base_path('views/partials/icons.php'); ?>

<section class="min-h-[80vh] flex items-center py-24 relative overflow-hidden">
    <div class="absolute inset-0 grid-mask"></div>
    <div class="mesh-bg" style="opacity:0.55"></div>

    <!-- Liquid orbs -->
    <div class="liquid-orb liquid-orb--indigo" style="width: 620px; height: 620px; top: -200px; left: -140px;"></div>
    <div class="liquid-orb liquid-orb--cyan"   style="width: 420px; height: 420px; top: 15%; right: -100px;"></div>
    <div class="liquid-orb liquid-orb--violet" style="width: 340px; height: 340px; bottom: -120px; left: 35%; opacity: 0.4;"></div>

    <div class="container relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <div class="glow-tag mb-8 mx-auto"><span class="text-chalk">Error <?= e((string)($code ?? 404)) ?></span></div>

            <div class="big-num text-grad-indigo text-[clamp(8rem,22vw,18rem)] leading-none mb-8 reveal">
                <?= e((string)($code ?? 404)) ?>
            </div>

            <h1 class="font-display font-normal tracking-tightest text-[clamp(2rem,5vw,4.25rem)] leading-[0.93] mb-6 text-balance">
                <?= e($message ?? 'Página no encontrada') ?><span class="text-italic-serif text-grad-indigo">.</span>
            </h1>
            <p class="text-chalk/60 mb-12 max-w-md mx-auto text-[16px] leading-relaxed">
                La página que buscas no existe o fue movida. Pero podemos ayudarte a encontrar lo que necesitas.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="<?= url('/') ?>" class="btn-ember sheen magnetic">
                    <?= icon('arrow-right', 'w-4 h-4 rotate-180') ?>
                    Volver al inicio
                </a>
                <a href="<?= url('/contact') ?>" class="btn-outline sheen">
                    Hablar con nosotros
                </a>
            </div>
        </div>
    </div>
</section>
