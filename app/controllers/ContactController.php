<?php
declare(strict_types=1);

require_once base_path('app/mailer.php');
require_once base_path('app/rate_limit.php');

class ContactController
{
    public function show(): void
    {
        render_view('contact', [], [
            'title'       => 'Contacto · KYROS Solutions',
            'description' => 'Hablemos de tu próximo proyecto. Respondemos en menos de 24 horas.',
        ]);
    }

    public function submit(): void
    {
        $input = [
            'name'    => trim((string)($_POST['name']    ?? '')),
            'email'   => trim((string)($_POST['email']   ?? '')),
            'company' => trim((string)($_POST['company'] ?? '')),
            'phone'   => trim((string)($_POST['phone']   ?? '')),
            'service' => trim((string)($_POST['service'] ?? '')),
            'message' => trim((string)($_POST['message'] ?? '')),
        ];

        // 1. Honeypot - real users do not fill this
        if (!empty($_POST['website'])) {
            // Pretend everything is fine to confuse bots
            flash('contact_status', 'success');
            redirect('/contact#form');
        }

        // 2. CSRF
        if (!csrf_check((string)($_POST['_csrf'] ?? ''))) {
            flash('contact_status', 'error');
            flash('contact_error', 'La sesión expiró. Recarga la página e inténtalo de nuevo.');
            set_old($input);
            redirect('/contact#form');
        }

        // 3. Validation
        $errors = $this->validate($input);
        if ($errors) {
            flash('contact_status', 'error');
            flash('contact_errors', $errors);
            set_old($input);
            redirect('/contact#form');
        }

        // 4. Rate limit per IP (5 per hour by default)
        $max    = (int) env('CONTACT_RATE_LIMIT_MAX', 5);
        $window = (int) env('CONTACT_RATE_LIMIT_WINDOW', 3600);
        if (!RateLimit::hit('contact', $max, $window)) {
            flash('contact_status', 'error');
            flash('contact_error', 'Has enviado demasiados mensajes. Intenta de nuevo en una hora.');
            set_old($input);
            redirect('/contact#form');
        }

        // 5. Send via Resend
        $result = Mailer::send([
            'to'      => env('MAIL_TO', 'info@kyrosrd.com'),
            'reply_to'=> $input['email'],
            'subject' => "Nuevo contacto desde el sitio: {$input['name']}",
            'html'    => $this->buildHtml($input),
        ]);

        if (!$result['ok']) {
            flash('contact_status', 'error');
            flash('contact_error', 'No se pudo enviar el mensaje: ' . $result['error']);
            set_old($input);
            redirect('/contact#form');
        }

        clear_old();
        flash('contact_status', 'success');
        redirect('/contact#form');
    }

    /** @return array<string,string> */
    private function validate(array $input): array
    {
        $errors = [];

        if (mb_strlen($input['name']) < 2) {
            $errors['name'] = 'Por favor ingresa tu nombre completo.';
        }
        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email inválido.';
        }
        if (mb_strlen($input['message']) < 10) {
            $errors['message'] = 'Cuéntanos un poco más sobre tu proyecto (mínimo 10 caracteres).';
        }
        // Soft cap to avoid abuse
        foreach (['name' => 120, 'company' => 160, 'phone' => 40, 'service' => 80, 'message' => 4000] as $f => $max) {
            if (mb_strlen($input[$f]) > $max) {
                $errors[$f] = "Máximo {$max} caracteres.";
            }
        }
        return $errors;
    }

    private function buildHtml(array $i): string
    {
        $rows = '';
        $fields = [
            'Nombre'   => $i['name'],
            'Email'    => $i['email'],
            'Empresa'  => $i['company'] ?: '—',
            'Teléfono' => $i['phone']   ?: '—',
            'Servicio' => $i['service'] ?: '—',
        ];
        foreach ($fields as $label => $val) {
            $rows .= '<tr>'
                . '<td style="padding:10px 14px;color:#9CA3AF;font-size:13px;border-bottom:1px solid #1F2937;width:140px;font-weight:600;">' . e($label) . '</td>'
                . '<td style="padding:10px 14px;color:#F9FAFB;font-size:14px;border-bottom:1px solid #1F2937;">' . e($val) . '</td>'
                . '</tr>';
        }

        $msg = nl2br(e($i['message']));
        $ip  = e(client_ip());
        $ua  = e(substr((string)($_SERVER['HTTP_USER_AGENT'] ?? '—'), 0, 200));
        $when = e(date('Y-m-d H:i:s'));

        return <<<HTML
<!doctype html>
<html><body style="margin:0;padding:0;background:#030014;font-family:-apple-system,BlinkMacSystemFont,Segoe UI,sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#030014;padding:32px 0;">
    <tr><td align="center">
      <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;background:#0F0826;border-radius:16px;overflow:hidden;border:1px solid #2A2450;">
        <tr><td style="background:linear-gradient(135deg,#7000FF,#00C2FF);padding:28px 32px;">
          <h1 style="margin:0;color:#fff;font-size:22px;font-weight:700;letter-spacing:-.5px;">Nuevo contacto en kyrosrd.com</h1>
          <p style="margin:6px 0 0;color:rgba(255,255,255,.85);font-size:14px;">Recibido el {$when}</p>
        </td></tr>
        <tr><td style="padding:24px 32px;">
          <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
            {$rows}
          </table>
          <div style="margin-top:24px;padding:18px;background:#161030;border-radius:12px;border:1px solid #2A2450;">
            <p style="margin:0 0 8px;color:#9CA3AF;font-size:12px;text-transform:uppercase;letter-spacing:.1em;font-weight:600;">Mensaje</p>
            <div style="color:#E5E7EB;font-size:15px;line-height:1.6;">{$msg}</div>
          </div>
        </td></tr>
        <tr><td style="padding:18px 32px 28px;background:#0A0420;border-top:1px solid #2A2450;">
          <p style="margin:0;color:#6B7280;font-size:11px;line-height:1.5;">IP: {$ip} · UA: {$ua}</p>
        </td></tr>
      </table>
    </td></tr>
  </table>
</body></html>
HTML;
    }
}
