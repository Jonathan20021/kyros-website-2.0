<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($title ?? 'KYROS Admin') ?></title>
    <link rel="icon" type="image/svg+xml" href="<?= asset('img/favicon.svg') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
</head>
<body class="min-h-screen bg-[#EFEFEF] flex items-center justify-center p-6 antialiased" style="font-family: 'Geist', system-ui, sans-serif; color: var(--ink);">

    <!-- Animated bg (reuse hero shader styles) -->
    <div class="hero-canvas" aria-hidden="true" style="position: fixed; inset: 0; z-index: 0;">
        <div class="hero-canvas__chroma"></div>
        <div class="hero-canvas__fluted"></div>
        <div class="hero-canvas__grain"></div>
    </div>

    <div class="relative z-10 w-full max-w-md">
        <div class="text-center mb-6">
            <a href="<?= url('/') ?>" class="inline-flex items-center gap-3">
                <img src="<?= asset('img/logo.png') ?>" alt="KYROS Solutions" style="height: 72px; width: auto; max-width: 220px; object-fit: contain;">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-[0.16em] self-center" style="background: var(--orange); color: #fff;">Admin</span>
            </a>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-[0_20px_50px_rgba(0,0,0,0.08)] border border-[rgba(17,17,17,0.06)]">
            <?= $content ?>
        </div>

        <p class="text-center mt-6 text-[12px]" style="color: var(--ink-muted);">
            © <?= date('Y') ?> KYROS Solutions
        </p>
    </div>
</body>
</html>
