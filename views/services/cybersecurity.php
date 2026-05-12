<?php
$service = [
    'eyebrow' => 'Ciberseguridad',
    'icon'    => 'shield',
    'title'   => 'Defensa <span class="text-italic-serif text-grad-ember">proactiva</span> para tu empresa.',
    'intro'   => 'Auditorías técnicas, ethical hacking, hardening y monitoreo continuo. Identificamos y cerramos vulnerabilidades antes de que un atacante las encuentre.',
    'hero_metrics' => [
        ['250+', 'Vulnerabilidades identificadas y cerradas'],
        ['<4 h', 'Tiempo medio de respuesta a incidentes'],
        ['100%', 'Reportes alineados a OWASP / ISO'],
        ['24/7', 'Monitoreo activo'],
    ],
    'features' => [
        ['icon' => 'eye', 'title' => 'Pentesting', 'desc' => 'Pruebas de penetración a aplicaciones web, móviles, APIs e infraestructura interna y perimetral.'],
        ['icon' => 'lock', 'title' => 'Auditorías de Seguridad', 'desc' => 'Revisión técnica completa con metodología OWASP, NIST e ISO 27001 y reporte ejecutivo.'],
        ['icon' => 'server', 'title' => 'Hardening de Servidores', 'desc' => 'Aseguramiento de servidores Linux/Windows, configuración de firewalls y políticas de acceso.'],
        ['icon' => 'cpu', 'title' => 'Monitoreo y SOC', 'desc' => 'SIEM, EDR y vigilancia activa 24/7 con alertas en tiempo real ante actividad sospechosa.'],
        ['icon' => 'shield', 'title' => 'Respuesta a Incidentes', 'desc' => 'Contención, análisis forense y plan de recuperación cuando algo sale mal.'],
        ['icon' => 'users', 'title' => 'Capacitación', 'desc' => 'Concientización a empleados sobre phishing, ingeniería social y buenas prácticas de seguridad.'],
    ],
    'deliverables' => [
        'Reporte ejecutivo con resumen para dirección',
        'Reporte técnico detallado con cada hallazgo y evidencia',
        'Clasificación de severidad (CVSS) y plan de remediación priorizado',
        'Sesión de revisión con tu equipo técnico',
        'Re-test gratuito tras la remediación',
        'Recomendaciones de políticas y procedimientos',
        'Checklist de hardening para futuras implementaciones',
    ],
    'process' => [
        ['num' => '01', 'title' => 'Reconocimiento', 'desc' => 'Mapeo de la superficie de ataque y definición del alcance del engagement.'],
        ['num' => '02', 'title' => 'Pruebas', 'desc' => 'Pentesting manual y automatizado, análisis de configuraciones y revisión de código.'],
        ['num' => '03', 'title' => 'Reporte', 'desc' => 'Documentación detallada de cada hallazgo con pruebas de concepto reproducibles.'],
        ['num' => '04', 'title' => 'Remediación', 'desc' => 'Acompañamiento durante la corrección y re-test para confirmar el cierre.'],
    ],
    'faqs' => [
        ['¿Necesito firmar algún acuerdo legal antes del pentest?', 'Sí. Firmamos un acuerdo de alcance (SOW), confidencialidad (NDA) y autorización formal antes de iniciar cualquier prueba. Es por tu protección y la nuestra.'],
        ['¿Las pruebas afectan la operación productiva?', 'Coordinamos ventanas de prueba, evitamos exploits destructivos y mantenemos comunicación constante. Si algo se ve afectado, lo notificamos al instante.'],
        ['¿Cumplen con normativas como PCI DSS o HIPAA?', 'Sí. Adaptamos nuestras auditorías a marcos regulatorios específicos (PCI DSS, HIPAA, ISO 27001, GDPR) según tu industria.'],
        ['¿Pueden monitorear nuestra infraestructura 24/7?', 'Ofrecemos servicios de SOC con SIEM, detección de amenazas y respuesta activa con personal humano, no solo bots.'],
    ],
    'related' => [
        ['slug' => 'software-development', 'icon' => 'code', 'title' => 'Desarrollo de Software'],
        ['slug' => 'network-infrastructure', 'icon' => 'wifi', 'title' => 'Infraestructura'],
        ['slug' => 'technical-support', 'icon' => 'headset', 'title' => 'Soporte & Helpdesk'],
    ],
];
require base_path('views/partials/service-detail.php');
