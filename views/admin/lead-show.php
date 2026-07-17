<?php
$svcKeys = array_filter(explode(',', (string) $lead['services']));
$svcText = [];
foreach ($svcKeys as $k) {
    if (isset($services[$k])) $svcText[] = $services[$k][0];
}

$rows = [
    'Email'            => $lead['email'],
    'Empresa'          => $lead['company'] ?: '—',
    'Teléfono'         => $lead['phone'] ?: '—',
    'Servicios'        => $svcText ? implode(', ', $svcText) : '—',
    'Presupuesto'      => BriefController::budgetLabelBoth((string) $lead['budget']),
    'Plazo'            => $timelines[$lead['timeline']] ?? '—',
    'Punto de partida' => $existing[$lead['has_existing']] ?? '—',
    'Nos conoció por'  => $heardFrom[$lead['heard_from']] ?? '—',
];

$statusLabels = [
    'nuevo'      => 'Nuevo',
    'contactado' => 'Contactado',
    'propuesta'  => 'Propuesta enviada',
    'ganado'     => 'Ganado',
    'perdido'    => 'Perdido',
];
?>

<div class="mb-5 flex flex-wrap items-center gap-3">
    <a href="<?= url('/admin/leads') ?>" class="text-[13px] font-medium hover:text-[#F26522] transition-colors" style="color: var(--ink-muted);">← Volver a solicitudes</a>
    <span class="lead-badge lead-badge--<?= e($lead['status']) ?>"><?= e($lead['status']) ?></span>
    <span class="font-mono text-[12px]" style="color: var(--ink-quiet);"><?= e($lead['ref']) ?></span>
</div>

<div class="grid lg:grid-cols-3 gap-5 items-start">

    <!-- Main -->
    <div class="lg:col-span-2 flex flex-col gap-5">
        <div class="admin-card">
            <h2 class="text-[17px] font-medium mb-1" style="color: var(--ink);"><?= e($lead['name']) ?></h2>
            <p class="text-[13px] mb-5" style="color: var(--ink-muted);">
                Recibido el <?= e(date('d/m/Y \a \l\a\s H:i', strtotime((string) $lead['created_at']))) ?>
            </p>

            <table class="w-full" style="border-collapse: collapse;">
                <?php foreach ($rows as $label => $val): ?>
                    <tr>
                        <td class="py-2.5 pr-4 text-[12px] font-semibold align-top" style="color: var(--ink-muted); width: 150px; border-bottom: 1px solid rgba(17,17,17,0.06);"><?= e($label) ?></td>
                        <td class="py-2.5 text-[14px]" style="color: var(--ink); border-bottom: 1px solid rgba(17,17,17,0.06);">
                            <?php if ($label === 'Email'): ?>
                                <a href="mailto:<?= e($lead['email']) ?>" class="hover:text-[#F26522] transition-colors" style="color: var(--ink);"><?= e($lead['email']) ?></a>
                            <?php else: ?>
                                <?= e((string) $val) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!empty($lead['existing_url'])): ?>
                    <tr>
                        <td class="py-2.5 pr-4 text-[12px] font-semibold align-top" style="color: var(--ink-muted); border-bottom: 1px solid rgba(17,17,17,0.06);">URL actual</td>
                        <td class="py-2.5 text-[14px]" style="border-bottom: 1px solid rgba(17,17,17,0.06);">
                            <a href="<?= e($lead['existing_url']) ?>" target="_blank" rel="noopener noreferrer" class="hover:text-[#F26522] transition-colors break-all" style="color: var(--ink);"><?= e($lead['existing_url']) ?></a>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <?php foreach (['Descripción' => $lead['description'], 'Objetivos' => $lead['goals'], 'Funcionalidades' => $lead['features']] as $label => $text): ?>
            <?php if (trim((string) $text) === '') continue; ?>
            <div class="admin-card">
                <p class="text-[11px] font-bold uppercase tracking-[0.1em] mb-2" style="color: var(--ink-muted);"><?= e($label) ?></p>
                <div class="text-[14px] leading-[1.7]" style="color: var(--ink);"><?= nl2br(e((string) $text)) ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Sidebar -->
    <div class="flex flex-col gap-5">
        <div class="admin-card">
            <p class="text-[11px] font-bold uppercase tracking-[0.1em] mb-3" style="color: var(--ink-muted);">Estado</p>
            <form method="POST" action="<?= url('/admin/leads/' . $lead['id'] . '/status') ?>" class="flex flex-col gap-2">
                <?= csrf_field() ?>
                <select name="status" class="admin-input">
                    <?php foreach ($statusLabels as $key => $label): ?>
                        <option value="<?= e($key) ?>" <?= $lead['status'] === $key ? 'selected' : '' ?>><?= e($label) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn-admin-primary w-full justify-center">Actualizar estado</button>
            </form>
        </div>

        <div class="admin-card">
            <p class="text-[11px] font-bold uppercase tracking-[0.1em] mb-3" style="color: var(--ink-muted);">Acciones</p>
            <a href="mailto:<?= e($lead['email']) ?>?subject=<?= e(rawurlencode('Tu proyecto con KYROS · ' . $lead['ref'])) ?>"
               class="btn-admin-primary w-full justify-center mb-2">Responder por correo</a>
            <?php if (!empty($lead['phone'])): ?>
                <a href="https://wa.me/<?= e(preg_replace('/\D+/', '', (string) $lead['phone'])) ?>" target="_blank" rel="noopener noreferrer"
                   class="btn-admin-ghost w-full justify-center">WhatsApp</a>
            <?php endif; ?>
        </div>

        <div class="admin-card">
            <p class="text-[11px] font-bold uppercase tracking-[0.1em] mb-3" style="color: var(--ink-muted);">Notas internas</p>
            <form method="POST" action="<?= url('/admin/leads/' . $lead['id'] . '/notes') ?>">
                <?= csrf_field() ?>
                <textarea name="admin_notes" rows="5" class="admin-input mb-2" placeholder="Solo el equipo ve esto…"><?= e((string) ($lead['admin_notes'] ?? '')) ?></textarea>
                <button type="submit" class="btn-admin-ghost w-full justify-center">Guardar notas</button>
            </form>
        </div>

        <div class="admin-card">
            <p class="text-[11px] font-bold uppercase tracking-[0.1em] mb-3" style="color: var(--ink-muted);">Entrega de correos</p>
            <div class="flex flex-col gap-2 text-[13px]">
                <div class="flex items-center justify-between">
                    <span style="color: var(--ink-muted);">Aviso al admin</span>
                    <span class="lead-mail <?= $lead['mail_admin_ok'] ? 'is-ok' : 'is-fail' ?>">
                        <?= $lead['mail_admin_ok'] ? 'Enviado' : 'Falló' ?>
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span style="color: var(--ink-muted);">Copia al cliente</span>
                    <span class="lead-mail <?= $lead['mail_client_ok'] ? 'is-ok' : 'is-fail' ?>">
                        <?= $lead['mail_client_ok'] ? 'Enviado' : 'Falló' ?>
                    </span>
                </div>
            </div>
            <?php if (!$lead['mail_client_ok']): ?>
                <p class="text-[11px] mt-3 leading-[1.5]" style="color: var(--ink-quiet);">
                    El cliente no recibió confirmación. Conviene responderle manualmente.
                </p>
            <?php endif; ?>
        </div>

        <div class="admin-card">
            <p class="text-[11px] font-bold uppercase tracking-[0.1em] mb-2" style="color: var(--ink-muted);">Origen</p>
            <p class="text-[11px] leading-[1.6] break-all" style="color: var(--ink-quiet);">
                IP: <?= e((string) ($lead['ip'] ?? '—')) ?><br>
                <?= e((string) ($lead['user_agent'] ?? '—')) ?>
            </p>
        </div>

        <form method="POST" action="<?= url('/admin/leads/' . $lead['id'] . '/delete') ?>"
              onsubmit="return confirm('¿Eliminar esta solicitud? No se puede deshacer.');">
            <?= csrf_field() ?>
            <button type="submit" class="text-[13px] font-medium hover:underline" style="color: #DC2626;">Eliminar solicitud</button>
        </form>
    </div>
</div>
