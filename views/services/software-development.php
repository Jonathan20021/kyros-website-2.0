<?php
$service = [
    'eyebrow' => 'Desarrollo de Software',
    'icon'    => 'code',
    'title'   => 'Software <span class="text-italic-serif text-grad-ember">a medida</span> que mueve negocios.',
    'intro'   => 'Diseñamos y construimos aplicaciones web, plataformas SaaS y sistemas empresariales robustos, escalables y mantenibles. Desde el primer wireframe hasta el primer cliente en producción.',
    'hero_metrics' => [
        ['8-12 sem', 'Tiempo medio para un MVP en producción'],
        ['100%', 'Código entregado y documentado'],
        ['24/7', 'Monitoreo post-lanzamiento'],
        ['+120', 'Productos digitales construidos'],
    ],
    'features' => [
        ['icon' => 'globe', 'title' => 'Aplicaciones Web', 'desc' => 'Dashboards, portales y SaaS multi-tenant con React, Vue, Laravel o Next.js.'],
        ['icon' => 'building', 'title' => 'Sistemas Empresariales', 'desc' => 'ERP, CRM, facturación, gestión documental y control de procesos a medida.'],
        ['icon' => 'server', 'title' => 'APIs e Integraciones', 'desc' => 'APIs REST y GraphQL, integraciones con ERP, CRM, pasarelas de pago y servicios externos.'],
        ['icon' => 'database', 'title' => 'Bases de Datos', 'desc' => 'Modelado relacional (MySQL, PostgreSQL) y NoSQL (MongoDB, Redis) optimizado para escala.'],
        ['icon' => 'cloud', 'title' => 'DevOps & Deploy', 'desc' => 'CI/CD, contenedores Docker, Kubernetes y despliegue automatizado en AWS, GCP o servidores propios.'],
        ['icon' => 'rocket', 'title' => 'Modernización Legacy', 'desc' => 'Refactorización progresiva de sistemas antiguos hacia arquitecturas modernas, sin tirar todo por la ventana.'],
    ],
    'deliverables' => [
        'Código fuente completo, organizado en tu propio repositorio Git',
        'Documentación técnica: arquitectura, decisiones, guía de despliegue',
        'Suite de pruebas automatizadas (unit, integración, end-to-end)',
        'Pipeline de CI/CD configurado y funcionando',
        'Dashboards de monitoreo y alertas',
        'Sesión de handoff con tu equipo técnico',
        'Manual de usuario y guía de operación',
        '60 días de garantía y soporte post-lanzamiento',
    ],
    'process' => [
        ['num' => '01', 'title' => 'Discovery', 'desc' => 'Workshop de 1-2 días para mapear objetivos, usuarios, restricciones y métricas.'],
        ['num' => '02', 'title' => 'Diseño UX/UI', 'desc' => 'Wireframes, prototipos clicables y design system validado antes de codear.'],
        ['num' => '03', 'title' => 'Sprints', 'desc' => 'Iteraciones de 2 semanas con demo cada viernes y feedback inmediato.'],
        ['num' => '04', 'title' => 'Lanzamiento', 'desc' => 'Despliegue gradual, monitoreo activo y soporte directo en las primeras semanas.'],
    ],
    'faqs' => [
        ['¿Trabajan con tecnologías específicas o son flexibles?', 'Tenemos preferencias por nuestro stack core (React, Next.js, Laravel, Node, PHP, Python) pero nos adaptamos al stack que mejor convenga al proyecto y a la realidad de tu equipo.'],
        ['¿Qué pasa con el código? ¿Es mío?', 'Por supuesto. Trabajamos en tu repositorio (o creamos uno y te lo transferimos). Todo el código y propiedad intelectual queda 100% bajo tu control.'],
        ['¿Pueden tomar un proyecto a medio camino?', 'Sí. Hacemos auditoría técnica del estado actual, identificamos riesgos y proponemos un plan de continuidad realista.'],
        ['¿Cómo manejan los cambios de alcance?', 'Trabajamos en sprints cortos justo para absorber cambios. Cada sprint comienza con priorización, así pivotamos sin caos.'],
    ],
    'related' => [
        ['slug' => 'cybersecurity', 'icon' => 'shield', 'title' => 'Ciberseguridad'],
        ['slug' => 'technical-support', 'icon' => 'headset', 'title' => 'Soporte & Helpdesk'],
        ['slug' => 'network-infrastructure', 'icon' => 'wifi', 'title' => 'Infraestructura'],
    ],
];
require base_path('views/partials/service-detail.php');
