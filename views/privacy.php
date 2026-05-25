<?php require_once base_path('views/partials/icons.php'); ?>

<section class="relative pt-32 sm:pt-36 pb-12 overflow-hidden bg-[#EFEFEF]">
    <div class="hero-canvas" aria-hidden="true">
        <div class="hero-canvas__chroma"></div>
        <div class="hero-canvas__fluted"></div>
        <div class="hero-canvas__grain"></div>
    </div>
    <div class="relative z-20 max-w-[1000px] mx-auto px-5 sm:px-8">
        <a href="<?= url('/') ?>" class="inline-flex items-center gap-2 text-[13px] font-mono mb-8 transition-colors hover:text-[#F26522]" style="color: var(--ink-soft);">
            ← Volver al inicio
        </a>
        <div class="section-badge mb-6">
            <span class="section-badge__num">§</span>
            <span class="section-badge__label">Legal</span>
        </div>
        <h1 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance mb-3"
            style="color: var(--ink); font-size: clamp(2rem, 5vw, 3.75rem);">
            Política de <em class="text-italic-serif">Privacidad</em>.
        </h1>
        <p class="text-[13px] font-mono mb-12" style="color: var(--ink-muted);">Última actualización: <?= date('d/m/Y') ?></p>
    </div>
</section>

<section class="bg-white py-16 sm:py-20">
    <div class="max-w-[820px] mx-auto px-5 sm:px-8">
        <div class="prose-legal">
            <p>
                En <strong>KYROS Solutions</strong> respetamos tu privacidad. Esta política explica qué información recopilamos cuando interactúas con nuestro sitio kyrosrd.com y cómo la utilizamos.
            </p>

            <h2>1. Información que recopilamos</h2>
            <ul>
                <li><strong>Información de contacto:</strong> nombre, email, empresa y teléfono que nos proporcionas voluntariamente al completar el formulario de contacto.</li>
                <li><strong>Datos técnicos:</strong> dirección IP, tipo de navegador, sistema operativo y páginas visitadas (recopilados con fines de seguridad y analítica anónima).</li>
                <li><strong>Cookies:</strong> utilizamos cookies estrictamente necesarias para el funcionamiento del sitio y la prevención de spam.</li>
            </ul>

            <h2>2. Cómo usamos tu información</h2>
            <ul>
                <li>Para responder tus consultas y entregar los servicios solicitados.</li>
                <li>Para mejorar nuestro sitio web y servicios.</li>
                <li>Para cumplir con obligaciones legales y proteger nuestros derechos.</li>
            </ul>
            <p><strong>No vendemos ni compartimos</strong> tu información personal con terceros para fines de marketing.</p>

            <h2>3. Conservación de datos</h2>
            <p>
                Conservamos tus datos solo durante el tiempo necesario para los fines descritos o según lo exija la ley. Puedes solicitar la eliminación de tus datos en cualquier momento escribiendo a <a href="mailto:info@kyrosrd.com">info@kyrosrd.com</a>.
            </p>

            <h2>4. Tus derechos</h2>
            <p>Tienes derecho a acceder, rectificar, eliminar u oponerte al tratamiento de tus datos personales. Para ejercer estos derechos, contáctanos.</p>

            <h2>5. Seguridad</h2>
            <p>
                Implementamos medidas técnicas y organizativas razonables para proteger tu información: cifrado en tránsito (HTTPS), control de accesos, auditorías periódicas y buenas prácticas de seguridad.
            </p>

            <h2>6. Cambios a esta política</h2>
            <p>Podemos actualizar esta política ocasionalmente. La fecha de la última revisión aparece al inicio de este documento.</p>

            <h2>7. Contacto</h2>
            <p>
                Si tienes preguntas sobre esta política, escríbenos a
                <a href="mailto:info@kyrosrd.com">info@kyrosrd.com</a> o llámanos al
                <a href="tel:+18495024061">+1 (849) 502-4061</a>.
            </p>
        </div>
    </div>
</section>

<style>
    .prose-legal { color: var(--ink-soft); font-size: 16px; line-height: 1.75; }
    .prose-legal h2 { color: var(--ink); font-size: 1.35rem; font-weight: 600; margin: 2.2em 0 0.6em; letter-spacing: -0.02em; }
    .prose-legal p { margin: 0 0 1.25em; }
    .prose-legal a { color: #F26522; text-decoration: underline; text-underline-offset: 3px; }
    .prose-legal a:hover { color: #E05A1A; }
    .prose-legal ul { margin: 0 0 1.5em 1.5em; }
    .prose-legal li { margin-bottom: 0.6em; }
    .prose-legal strong { color: var(--ink); font-weight: 600; }
</style>
