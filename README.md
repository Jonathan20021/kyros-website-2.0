# KYROS Solutions — Sitio Corporativo (PHP + Tailwind)

Rewrite del sitio corporativo en **PHP puro 8.2 + Tailwind CSS 3** compilado.
Sin frameworks, sin Composer en runtime, sin dependencias de Node en producción.

## Stack
- **PHP 8.2** (PHP-FPM o Apache `mod_php`)
- **Tailwind CSS 3** (CLI) compilado a `assets/css/app.css`
- **Resend** vía HTTP API (cURL) para correos del formulario de contacto
- **Vanilla JS** para interacciones (mobile nav, FAQ, reveal-on-scroll)

## Estructura
```
kyros/
├── index.php                    ← Front controller (router)
├── .htaccess                    ← Rewrite + headers de seguridad
├── .env                         ← Configuración local (NO subir a git)
├── .env.example                 ← Plantilla de variables
├── app/
│   ├── env.php                  ← Cargador .env minimalista
│   ├── helpers.php              ← url(), asset(), e(), csrf, flash, old, etc.
│   ├── router.php               ← Router HTTP simple
│   ├── view.php                 ← Render de vistas + partials
│   ├── mailer.php               ← Cliente Resend (cURL)
│   ├── rate_limit.php           ← Rate limiter por IP, file-based
│   └── controllers/
│       └── ContactController.php
├── views/
│   ├── layouts/base.php         ← Layout HTML maestro
│   ├── partials/
│   │   ├── header.php
│   │   ├── footer.php
│   │   ├── icons.php            ← Helper icon('shield', 'w-6 h-6')
│   │   └── service-detail.php   ← Layout reusable para servicios
│   ├── home.php
│   ├── about.php
│   ├── contact.php
│   ├── privacy.php
│   ├── terms.php
│   ├── 404.php
│   └── services/
│       ├── index.php
│       ├── software-development.php
│       ├── cybersecurity.php
│       ├── technical-support.php
│       └── network-infrastructure.php
├── resources/css/input.css      ← Fuente Tailwind
├── assets/
│   ├── css/app.css              ← CSS compilado (no editar a mano)
│   └── img/favicon.svg
├── storage/
│   ├── logs/mail.log            ← Log de envíos de correo
│   └── cache/                   ← Rate limiter
├── tailwind.config.js
├── package.json
└── README.md
```

## Setup local (XAMPP)

1. **Clona / descomprime** este folder dentro de `c:\xampp\htdocs\kyros\`.
2. Asegúrate de que **Apache esté corriendo** desde XAMPP Control Panel.
3. Verifica que `mod_rewrite` esté habilitado (viene activado por defecto en XAMPP).
4. Visita: **http://localhost/kyros**

### Configurar Resend

1. Crea cuenta en [resend.com](https://resend.com) y genera una API key.
2. Verifica tu dominio (`kyrosrd.com`) en el dashboard de Resend.
3. Edita `.env`:
   ```
   RESEND_API_KEY=rk_tu_api_key_aqui
   MAIL_FROM="KYROS Solutions <noreply@kyrosrd.com>"
   MAIL_TO=info@kyrosrd.com
   ```
4. Mientras no haya API key, el formulario muestra un error controlado y los intentos se loguean en `storage/logs/mail.log`. **No falla silenciosamente.**

> Para pruebas rápidas sin verificar dominio: usa `MAIL_FROM="onboarding@resend.dev"` (default Resend), pero solo enviará a la dirección registrada en tu cuenta.

## Compilar CSS (Tailwind)

```bash
# Una sola vez (requiere Node 18+)
npm install

# Modo desarrollo (watch + hot rebuild)
npm run dev

# Build de producción (minificado)
npm run build
```

El CSS se compila a `assets/css/app.css` (~50 KB minificado).
**Node solo se necesita para compilar CSS** — el sitio en sí no depende de Node en runtime.

## Rutas

| Método | Path                                    | Vista                              |
|--------|-----------------------------------------|------------------------------------|
| GET    | `/`                                     | `home.php`                         |
| GET    | `/services`                             | `services/index.php`               |
| GET    | `/services/software-development`        | `services/software-development.php`|
| GET    | `/services/cybersecurity`               | `services/cybersecurity.php`       |
| GET    | `/services/technical-support`           | `services/technical-support.php`   |
| GET    | `/services/network-infrastructure`      | `services/network-infrastructure.php` |
| GET    | `/about`                                | `about.php`                        |
| GET    | `/contact`                              | `contact.php`                      |
| POST   | `/contact`                              | Resend + redirect (PRG)            |
| GET    | `/privacy`                              | `privacy.php`                      |
| GET    | `/terms`                                | `terms.php`                        |

## Seguridad

El formulario de contacto incluye:
- ✅ **Token CSRF** (sesión PHP, comparación con `hash_equals`)
- ✅ **Honeypot** (campo invisible `website` que humanos no llenan)
- ✅ **Rate limiting** por IP (5 envíos/hora por defecto, configurable en `.env`)
- ✅ **Validación server-side** (longitud, email, max chars)
- ✅ **Escape HTML** en todo output (`e()` helper)
- ✅ **Pattern POST → Redirect → GET** (no doble envío al refrescar)

`.htaccess` añade:
- Bloqueo de acceso a `.env`, `app/`, `views/`, `storage/`
- Headers de seguridad: `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, `Permissions-Policy`
- Compresión gzip + cache de assets estáticos

## Despliegue a producción

1. **Compila el CSS** en local (`npm run build`).
2. Sube **todo el folder excepto** `node_modules/`, `storage/logs/*`, `storage/cache/*` y `.env`.
3. Crea `.env` en el servidor con la API key real y `APP_URL` apuntando al dominio:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://kyrosrd.com
   ```
4. Asegura que `storage/logs/` y `storage/cache/` sean **escribibles** por el usuario web (chmod 775).
5. Verifica que `mod_rewrite` esté activo en Apache. En Nginx, añade equivalente:
   ```nginx
   try_files $uri $uri/ /index.php?$query_string;
   ```

## Edición de contenido

- **Copy de páginas:** edita el `.php` correspondiente en `views/`.
- **Servicios:** cada uno es un array PHP en `views/services/<slug>.php` que se inyecta en `views/partials/service-detail.php`. Para añadir uno nuevo: copia un archivo, cambia los datos, agrega la ruta en `index.php`.
- **Colores / fuentes:** `tailwind.config.js` (recompila con `npm run build`).
- **Estilos custom:** `resources/css/input.css` (capas `@layer components` y `@layer utilities`).

## Licencia
© 2026 KYROS Solutions. Todos los derechos reservados.
