<?php
declare(strict_types=1);

/**
 * Resend HTTP API client (no SDK, pure cURL).
 *
 * Falls back to logging into storage/logs/mail.log when the API key is missing
 * or the request fails — so local dev never silently breaks the contact form.
 */
class Mailer
{
    public static function send(array $payload): array
    {
        $required = ['to', 'subject', 'html'];
        foreach ($required as $field) {
            if (empty($payload[$field])) {
                return ['ok' => false, 'error' => "Campo requerido faltante: {$field}"];
            }
        }

        $payload['from'] = $payload['from'] ?? env('MAIL_FROM', 'noreply@example.com');

        $apiKey = env('RESEND_API_KEY');
        if (!$apiKey) {
            self::logToFile('NO API KEY - email not sent', $payload);
            return ['ok' => false, 'error' => 'Resend no está configurado. Revisa el archivo .env.'];
        }

        $ch = curl_init('https://api.resend.com/emails');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $apiKey,
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $response = curl_exec($ch);
        $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err      = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            self::logToFile('cURL error: ' . $err, $payload);
            return ['ok' => false, 'error' => 'No se pudo conectar al servicio de correo.'];
        }

        $data = json_decode($response, true);

        if ($status >= 200 && $status < 300 && !empty($data['id'])) {
            self::logToFile("OK id={$data['id']}", $payload);
            return ['ok' => true, 'id' => $data['id']];
        }

        $errMsg = $data['message'] ?? "HTTP {$status}";
        self::logToFile("FAIL ({$status}): {$errMsg}", $payload);
        return ['ok' => false, 'error' => $errMsg];
    }

    private static function logToFile(string $status, array $payload): void
    {
        $logDir = base_path('storage/logs');
        if (!is_dir($logDir)) @mkdir($logDir, 0775, true);

        $line = sprintf(
            "[%s] %s | to=%s | subject=%s\n",
            date('c'),
            $status,
            is_array($payload['to']) ? implode(',', $payload['to']) : $payload['to'],
            $payload['subject']
        );
        @file_put_contents($logDir . '/mail.log', $line, FILE_APPEND);
    }
}
