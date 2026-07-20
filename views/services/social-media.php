<?php
$service = [
    'eyebrow' => 'Redes Sociales',
    'icon'    => 'share',
    'anim'    => 'social',
    // Rose theme — distinct from the four technical services so the newest
    // offering reads as its own thing across the whole page and its scene.
    'color_fg'   => '#DB2777',
    'color_bg'   => '#FDF2F8',
    'color_bd'   => '#FBCFE8',
    'accent_rgb' => '219, 39, 119',
    'title'   => 'Redes sociales que <span class="text-italic-serif">construyen marca</span>.',
    'intro'   => 'Manejamos la presencia digital de empresas y personas: estrategia, contenido, community management y campañas. Tú te enfocas en tu negocio; nosotros en que tu marca crezca y se vea profesional en cada plataforma.',
    'hero_metrics' => [
        ['5+', 'Plataformas gestionadas por cuenta'],
        ['Diario', 'Publicación y gestión de comunidad'],
        ['Mensual', 'Reporte de métricas y estrategia'],
        ['24/7', 'Monitoreo de menciones y mensajes'],
    ],
    'features' => [
        ['icon' => 'target', 'title' => 'Estrategia de Contenido', 'desc' => 'Definimos línea editorial, tono de marca y un calendario mensual alineado a tus objetivos de negocio.'],
        ['icon' => 'palette', 'title' => 'Diseño y Creativos', 'desc' => 'Piezas gráficas, carruseles, reels y stories con una identidad visual coherente y profesional.'],
        ['icon' => 'message', 'title' => 'Community Management', 'desc' => 'Respondemos comentarios y mensajes, moderamos y construimos una comunidad real alrededor de tu marca.'],
        ['icon' => 'trending', 'title' => 'Campañas Pagadas (Ads)', 'desc' => 'Meta Ads, TikTok Ads y Google: segmentación precisa, control de presupuesto y optimización continua.'],
        ['icon' => 'pie-chart', 'title' => 'Analítica y Reportes', 'desc' => 'Las métricas que importan —alcance, engagement y conversión— en reportes claros, sin humo.'],
        ['icon' => 'play', 'title' => 'Foto y Video', 'desc' => 'Producción de contenido audiovisual: reels, shorts y sesiones que hacen ver tu marca en grande.'],
    ],
    'deliverables' => [
        'Calendario editorial mensual, aprobado por ti antes de publicar',
        'Parrilla de contenidos lista: diseño, copy y hashtags',
        'Piezas gráficas y plantillas con la identidad de tu marca',
        'Guion y edición de reels y videos cortos',
        'Gestión diaria de comentarios y mensajes',
        'Configuración y optimización de campañas publicitarias',
        'Reporte mensual de métricas, aprendizajes y próximos pasos',
        'Reunión de estrategia cada mes',
    ],
    'process' => [
        ['num' => '01', 'title' => 'Auditoría', 'desc' => 'Analizamos tus redes actuales, tu competencia y tu audiencia para partir de datos, no de suposiciones.'],
        ['num' => '02', 'title' => 'Estrategia', 'desc' => 'Definimos objetivos, línea editorial, tono y el calendario de contenido del mes.'],
        ['num' => '03', 'title' => 'Producción', 'desc' => 'Creamos todo: diseño, copy, fotografía y video, listo para tu aprobación.'],
        ['num' => '04', 'title' => 'Publicación y Optimización', 'desc' => 'Publicamos, gestionamos la comunidad y ajustamos según lo que dicen los números.'],
    ],
    'faqs' => [
        ['¿Trabajan con personas o solo con empresas?', 'Con ambos. Manejamos marcas personales, profesionales e influencers, además de empresas de cualquier tamaño. La estrategia se adapta a quién eres y a dónde quieres llegar.'],
        ['¿Incluye la creación de contenido o solo publicar?', 'Incluye todo: estrategia, diseño, copy, fotografía y video. Tú apruebas cada pieza antes de que salga. No solo programamos posts, construimos tu presencia.'],
        ['¿Qué plataformas manejan?', 'Instagram, Facebook, TikTok, LinkedIn y X (Twitter). Priorizamos las plataformas donde realmente está tu audiencia, en vez de estar en todas por estar.'],
        ['¿Necesito invertir en publicidad?', 'No es obligatorio, pero la pauta potencia mucho los resultados. Gestionamos el presupuesto que definas con total transparencia y te mostramos el retorno.'],
    ],
    'related' => [
        ['slug' => 'software-development', 'icon' => 'code', 'title' => 'Desarrollo de Software'],
        ['slug' => 'technical-support', 'icon' => 'headset', 'title' => 'Soporte & Helpdesk'],
        ['slug' => 'cybersecurity', 'icon' => 'shield', 'title' => 'Ciberseguridad'],
    ],
];
require base_path('views/partials/service-detail.php');
