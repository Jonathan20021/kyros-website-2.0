<?php
$service = [
    'eyebrow' => 'Soporte & Helpdesk',
    'icon'    => 'headset',
    'anim'    => 'support',
    'title'   => 'Mesa de ayuda <span class="text-italic-serif text-grad-ember">24/7</span> que sí responde.',
    'intro'   => 'Soporte técnico profesional con SLA garantizado. Resolvemos en minutos, no en días. Personas reales atendiendo a tu equipo y tus clientes, con la trazabilidad de un sistema enterprise.',
    'hero_metrics' => [
        ['<15 min', 'Tiempo de primera respuesta'],
        ['98%', 'Casos resueltos en primer contacto'],
        ['4.9/5', 'Satisfacción del usuario final'],
        ['24/7', 'Cobertura sin interrupciones'],
    ],
    'features' => [
        ['icon' => 'message', 'title' => 'Helpdesk Multinivel', 'desc' => 'Soporte L1 (atención), L2 (técnico) y L3 (especialista) escalado de forma transparente.'],
        ['icon' => 'cpu', 'title' => 'Soporte Remoto', 'desc' => 'Resolución de incidencias por escritorio remoto, chat o teléfono — sin desplazamiento.'],
        ['icon' => 'building', 'title' => 'On-site', 'desc' => 'Visitas técnicas en sitio para incidencias críticas en República Dominicana.'],
        ['icon' => 'briefcase', 'title' => 'Gestión de Activos', 'desc' => 'Inventario, ciclo de vida y mantenimiento preventivo de toda tu flota tecnológica.'],
        ['icon' => 'database', 'title' => 'Backup y Recuperación', 'desc' => 'Estrategias de respaldo automatizadas con RPO/RTO acordados y pruebas periódicas.'],
        ['icon' => 'pie-chart', 'title' => 'Reportes Mensuales', 'desc' => 'Dashboards con tickets, tiempos, SLA y tendencias para que sepas qué está pasando.'],
    ],
    'deliverables' => [
        'Onboarding completo de tu equipo en KyDesk (nuestra plataforma)',
        'Acuerdo de Nivel de Servicio (SLA) firmado y medible',
        'Canal directo: portal, email, WhatsApp y teléfono',
        'Dashboard con métricas en tiempo real (24/7)',
        'Reporte mensual de operación con análisis de tendencias',
        'Sesión trimestral de revisión y mejora continua',
    ],
    'process' => [
        ['num' => '01', 'title' => 'Onboarding', 'desc' => 'Levantamiento de tu infraestructura, usuarios y sistemas críticos. Definición de SLA.'],
        ['num' => '02', 'title' => 'Recepción', 'desc' => 'Tickets entran por cualquier canal y son priorizados automáticamente.'],
        ['num' => '03', 'title' => 'Resolución', 'desc' => 'L1 atiende, escala a L2/L3 si requiere. Comunicación constante al usuario.'],
        ['num' => '04', 'title' => 'Mejora', 'desc' => 'Análisis de causa raíz para evitar que el mismo problema se repita.'],
    ],
    'faqs' => [
        ['¿Atienden en español, inglés o ambos?', 'Atendemos en ambos idiomas. Nuestro equipo es bilingüe y manejamos documentación en el idioma que prefieras.'],
        ['¿Qué pasa si tengo una incidencia fuera de horario?', 'Justamente por eso ofrecemos 24/7. Tenemos turnos rotativos cubriendo madrugadas, fines de semana y feriados.'],
        ['¿Hay que pagar por ticket o es tarifa fija?', 'Trabajamos con tarifas fijas mensuales según el tamaño de tu operación. Sin sorpresas, sin micro-cobros.'],
        ['¿Qué es KyDesk?', 'KyDesk es nuestra plataforma propia de helpdesk. Tus usuarios la usan para reportar incidencias y tu equipo directivo la usa para ver métricas en tiempo real.'],
    ],
    'related' => [
        ['slug' => 'social-media', 'icon' => 'share', 'title' => 'Redes Sociales'],
        ['slug' => 'network-infrastructure', 'icon' => 'wifi', 'title' => 'Infraestructura de Redes'],
        ['slug' => 'cybersecurity', 'icon' => 'shield', 'title' => 'Ciberseguridad'],
        ['slug' => 'software-development', 'icon' => 'code', 'title' => 'Desarrollo de Software'],
    ],
];
require base_path('views/partials/service-detail.php');
