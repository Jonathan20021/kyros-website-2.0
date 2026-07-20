<?php
$service = [
    'eyebrow' => 'Infraestructura de Redes',
    'icon'    => 'wifi',
    'anim'    => 'network',
    'title'   => 'Redes empresariales <span class="text-italic-serif text-grad-ember">de alto rendimiento</span>.',
    'intro'   => 'Diseñamos, instalamos y administramos la red que tu empresa necesita: cableado certificado, WiFi de alta densidad, firewalls, segmentación, VPN y enlaces dedicados con la confiabilidad que tu operación exige.',
    'hero_metrics' => [
        ['99.9%', 'Uptime de redes administradas'],
        ['10 GbE', 'Capacidad media en backbone'],
        ['ISO', 'Cableado certificado bajo norma'],
        ['+200', 'Sitios desplegados'],
    ],
    'features' => [
        ['icon' => 'wifi', 'title' => 'WiFi 6 Empresarial', 'desc' => 'Diseño basado en site survey, alta densidad, roaming sin cortes y SSID segmentados por área.'],
        ['icon' => 'server', 'title' => 'Cableado Estructurado', 'desc' => 'Categoría 6A o fibra óptica certificada, etiquetado profesional y documentación as-built.'],
        ['icon' => 'shield', 'title' => 'Firewalls y Perímetro', 'desc' => 'Firewalls UTM/NGFW (FortiGate, Sophos, MikroTik) con políticas, IPS/IDS y filtrado web.'],
        ['icon' => 'globe', 'title' => 'Enlaces y VPN', 'desc' => 'Enlaces dedicados, balanceo entre proveedores y VPN site-to-site / road-warrior cifradas.'],
        ['icon' => 'layers', 'title' => 'Segmentación VLAN', 'desc' => 'Separación lógica de redes (administración, voz, IoT, invitados) con políticas inter-VLAN.'],
        ['icon' => 'cpu', 'title' => 'Monitoreo NMS', 'desc' => 'Plataforma de monitoreo 24/7 con alertas proactivas y reportes de performance mensual.'],
    ],
    'deliverables' => [
        'Documentación as-built completa: planos, diagramas L2/L3, IPAM',
        'Certificación de cableado por enlace (Fluke / similar)',
        'Configuración respaldada de cada equipo (firewall, switch, AP)',
        'Site survey de WiFi pre y post-instalación con mapas de calor',
        'Manual de operación y procedimientos de contingencia',
        'Capacitación a tu equipo técnico interno',
        'Garantía de mano de obra de 12 meses',
    ],
    'process' => [
        ['num' => '01', 'title' => 'Levantamiento', 'desc' => 'Visita técnica, site survey y entendimiento de necesidades actuales y futuras.'],
        ['num' => '02', 'title' => 'Diseño', 'desc' => 'Arquitectura propuesta con diagramas, BOM (lista de materiales) y plan de implementación.'],
        ['num' => '03', 'title' => 'Implementación', 'desc' => 'Instalación, configuración y pruebas con cero impacto en operación productiva.'],
        ['num' => '04', 'title' => 'Soporte', 'desc' => 'Monitoreo continuo, mantenimiento preventivo y soporte ante incidencias.'],
    ],
    'faqs' => [
        ['¿Trabajan con marcas específicas o son agnósticos?', 'Somos agnósticos. Trabajamos con Cisco, Aruba, FortiGate, MikroTik, Ubiquiti, Sophos y otras según tu presupuesto y necesidades.'],
        ['¿Pueden migrar nuestra red sin downtime?', 'Sí. Diseñamos planes de migración por fases (out-of-band, fail-over) para minimizar o eliminar el corte. Toda migración crítica se hace fuera de horario.'],
        ['¿Incluyen mantenimiento después de la instalación?', 'Ofrecemos contratos de mantenimiento mensual con monitoreo 24/7, parches de seguridad y respuesta a incidencias con SLA.'],
        ['¿Cubren oficinas en distintas ciudades o países?', 'Sí. Diseñamos topologías multi-sitio con VPN, SD-WAN o MPLS y operamos remotamente con visitas on-site puntuales.'],
    ],
    'related' => [
        ['slug' => 'social-media', 'icon' => 'share', 'title' => 'Redes Sociales'],
        ['slug' => 'cybersecurity', 'icon' => 'shield', 'title' => 'Ciberseguridad'],
        ['slug' => 'technical-support', 'icon' => 'headset', 'title' => 'Soporte & Helpdesk'],
        ['slug' => 'software-development', 'icon' => 'code', 'title' => 'Desarrollo de Software'],
    ],
];
require base_path('views/partials/service-detail.php');
