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
            Términos y <em class="text-italic-serif">Condiciones</em>.
        </h1>
        <p class="text-[13px] font-mono mb-12" style="color: var(--ink-muted);">Última actualización: <?= date('d/m/Y') ?></p>
    </div>
</section>

<section class="bg-white py-16 sm:py-20">
    <div class="max-w-[820px] mx-auto px-5 sm:px-8">
        <div class="prose-legal">
            <p>
                Bienvenido a kyrosrd.com. Al acceder y utilizar este sitio web aceptas los siguientes términos y condiciones. Si no estás de acuerdo, te pedimos no usar el sitio.
            </p>

            <h2>1. Uso del sitio</h2>
            <p>Este sitio se proporciona con fines informativos sobre los servicios ofrecidos por <strong>KYROS Solutions</strong>. No se permite:</p>
            <ul>
                <li>Realizar actividades ilegales o que violen los derechos de terceros.</li>
                <li>Intentar comprometer la seguridad o disponibilidad del sitio.</li>
                <li>Recopilar datos de usuarios sin su consentimiento.</li>
            </ul>

            <h2>2. Propiedad intelectual</h2>
            <p>
                Todo el contenido del sitio (textos, gráficos, logos, código) es propiedad de KYROS Solutions o de sus licenciantes y está protegido por las leyes de propiedad intelectual. No se permite reproducirlo sin autorización por escrito.
            </p>

            <h2>3. Servicios</h2>
            <p>
                La información sobre nuestros servicios es referencial. La contratación de servicios se rige por contratos específicos firmados entre las partes, donde se establecen alcances, plazos, precios y SLA.
            </p>

            <h2>4. Limitación de responsabilidad</h2>
            <p>
                KYROS Solutions no se hace responsable por daños indirectos, incidentales o consecuentes derivados del uso de este sitio. La información se proporciona "tal cual" sin garantías expresas o implícitas más allá de lo permitido por la ley.
            </p>

            <h2>5. Enlaces a terceros</h2>
            <p>
                El sitio puede contener enlaces a sitios de terceros. No nos hacemos responsables del contenido o las prácticas de privacidad de dichos sitios.
            </p>

            <h2>6. Modificaciones</h2>
            <p>
                Nos reservamos el derecho de modificar estos términos en cualquier momento. Los cambios entran en vigor desde su publicación en el sitio.
            </p>

            <h2>7. Ley aplicable</h2>
            <p>
                Estos términos se rigen por las leyes de la República Dominicana. Cualquier controversia se someterá a los tribunales competentes de Santo Domingo.
            </p>

            <h2>8. Contacto</h2>
            <p>
                Para cualquier pregunta sobre estos términos:
                <a href="mailto:info@kyrosrd.com">info@kyrosrd.com</a> ·
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
