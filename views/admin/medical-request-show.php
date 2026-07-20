<?php
$name     = MedicalSiteController::displayName($req);
$spec     = MedicalSiteController::specialtyLabel($req);
$plans    = MedicalSiteController::PLANS;
$plan     = $plans[$req['plan']] ?? null;
$extras   = MedicalSiteController::extraLabels($req['extras'] ?? null);
$days     = MedicalSiteController::DAYS;
$networks = MedicalSiteController::SOCIAL_NETWORKS;
$labels   = MedicalRequest::STATUS_LABELS;

$identity = [
    'Especialidad'     => $spec,
    'Subespecialidad'  => $req['subspecialty'] ?: '—',
    'Exequátur'        => $req['license'] ?: '—',
    'Experiencia'      => $req['years_experience'] ? $req['years_experience'] . ' años' : '—',
    'Idiomas'          => $req['languages'] ?: '—',
];

$contact = [
    'Email'    => $req['email'],
    'Teléfono' => $req['phone'] ?: '—',
    'WhatsApp' => $req['whatsapp'] ?: '—',
    'Ciudad'   => $req['city'] ?: '—',
    'Dominio'  => (MedicalSiteController::DOMAIN_STATUS[$req['domain_status']] ?? '—')
                  . ($req['domain_name'] ? ' · ' . $req['domain_name'] : ''),
];
?>

<div class="mb-5 flex flex-wrap items-center gap-3">
    <a href="<?= url('/admin/medicos') ?>" class="text-[13px] font-medium hover:text-[#0D9488] transition-colors" style="color: var(--ink-muted);">← Volver a webs médicas</a>
    <span class="med-badge med-badge--<?= e($req['status']) ?>"><?= e($labels[$req['status']] ?? $req['status']) ?></span>
    <span class="font-mono text-[12px]" style="color: var(--ink-quiet);"><?= e($req['ref']) ?></span>
</div>

<div class="grid lg:grid-cols-3 gap-5 items-start">

    <!-- ══════════════ MAIN ══════════════ -->
    <div class="lg:col-span-2 flex flex-col gap-5">

        <!-- Identity -->
        <div class="admin-card">
            <div class="flex items-start gap-4 mb-5 flex-wrap">
                <?php if (!empty($req['portrait_url'])): ?>
                    <img src="<?= e(med_asset_url($req['portrait_url'])) ?>" alt="" class="med-avatar med-avatar--lg">
                <?php else: ?>
                    <span class="med-avatar med-avatar--lg med-avatar--empty"><?= e(mb_strtoupper(mb_substr($req['full_name'] ?: '?', 0, 1))) ?></span>
                <?php endif; ?>
                <div class="flex-1 min-w-[200px]">
                    <h2 class="text-[19px] font-medium leading-tight" style="color: var(--ink);"><?= e($name) ?></h2>
                    <p class="text-[13.5px] mt-0.5" style="color: #0D9488;"><?= e($spec) ?></p>
                    <p class="text-[12px] mt-1.5" style="color: var(--ink-muted);">
                        Recibido el <?= e(date('d/m/Y \a \l\a\s H:i', strtotime((string) $req['created_at']))) ?>
                    </p>
                </div>
            </div>

            <table class="w-full" style="border-collapse: collapse;">
                <?php foreach ($identity as $label => $val): ?>
                    <tr>
                        <td class="py-2.5 pr-4 text-[12px] font-semibold align-top" style="color: var(--ink-muted); width: 150px; border-bottom: 1px solid rgba(17,17,17,0.06);"><?= e($label) ?></td>
                        <td class="py-2.5 text-[14px]" style="color: var(--ink); border-bottom: 1px solid rgba(17,17,17,0.06);"><?= e((string) $val) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- Contact -->
        <div class="admin-card">
            <p class="text-[11px] font-bold uppercase tracking-[0.1em] mb-3" style="color: var(--ink-muted);">Contacto</p>
            <table class="w-full" style="border-collapse: collapse;">
                <?php foreach ($contact as $label => $val): ?>
                    <tr>
                        <td class="py-2.5 pr-4 text-[12px] font-semibold align-top" style="color: var(--ink-muted); width: 150px; border-bottom: 1px solid rgba(17,17,17,0.06);"><?= e($label) ?></td>
                        <td class="py-2.5 text-[14px]" style="color: var(--ink); border-bottom: 1px solid rgba(17,17,17,0.06);">
                            <?php if ($label === 'Email'): ?>
                                <a href="mailto:<?= e($req['email']) ?>" class="hover:text-[#0D9488] transition-colors" style="color: var(--ink);"><?= e($req['email']) ?></a>
                            <?php else: ?>
                                <?= e((string) $val) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <?php if ($socials): ?>
                <p class="text-[11px] font-bold uppercase tracking-[0.1em] mt-5 mb-2.5" style="color: var(--ink-muted);">Redes sociales</p>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($socials as $net => $handle): ?>
                        <span class="med-chip">
                            <strong><?= e($networks[$net][0] ?? $net) ?></strong>
                            <?= e((string) $handle) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Content blocks — the raw material for the site -->
        <?php foreach ([
            'Biografía'               => $req['bio'],
            'Formación y carrera'     => $req['career'],
            'Servicios y procedimientos' => $req['services_offered'],
            'Seguros y ARS'           => $req['insurances'],
            'Comentarios del médico'  => $req['notes'],
        ] as $label => $text): ?>
            <?php if (trim((string) $text) === '') continue; ?>
            <div class="admin-card">
                <div class="flex items-center justify-between gap-3 mb-2">
                    <p class="text-[11px] font-bold uppercase tracking-[0.1em]" style="color: var(--ink-muted);"><?= e($label) ?></p>
                    <button type="button" class="med-copy" data-copy="<?= e((string) $text) ?>">Copiar</button>
                </div>
                <div class="text-[14px] leading-[1.7]" style="color: var(--ink);"><?= nl2br(e((string) $text)) ?></div>
            </div>
        <?php endforeach; ?>

        <!-- Consultorios -->
        <div class="admin-card">
            <p class="text-[11px] font-bold uppercase tracking-[0.1em] mb-4" style="color: var(--ink-muted);">
                Consultorios y horarios (<?= count($clinics) ?>)
            </p>

            <?php if (!$clinics): ?>
                <p class="text-[13.5px]" style="color: var(--ink-muted);">No indicó consultorios.</p>
            <?php else: foreach ($clinics as $n => $c):
                $sched = is_array($c['sched'] ?? null) ? $c['sched'] : [];
            ?>
                <div class="med-office">
                    <div class="med-office__head">
                        <span class="med-office__num"><?= $n + 1 ?></span>
                        <div class="flex-1 min-w-0">
                            <h3 class="med-office__name"><?= e($c['name'] ?: 'Consultorio sin nombre') ?></h3>
                            <?php
                            $line = array_filter([$c['address'] ?? '', $c['suite'] ?? '']);
                            if ($line): ?>
                                <p class="med-office__addr"><?= e(implode(' · ', $line)) ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="flex flex-col items-end gap-1 flex-shrink-0">
                            <?php if (!empty($c['phone'])): ?>
                                <a href="tel:<?= e(preg_replace('/[^\d+]/', '', (string) $c['phone'])) ?>" class="med-office__link"><?= e($c['phone']) ?></a>
                            <?php endif; ?>
                            <?php if (!empty($c['maps'])): ?>
                                <a href="<?= e($c['maps']) ?>" target="_blank" rel="noopener noreferrer" class="med-office__link">Ver mapa →</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($sched): ?>
                        <div class="med-week">
                            <?php foreach ($days as $key => [$short, $full]):
                                $on = !empty($sched[$key]['from']) && !empty($sched[$key]['to']);
                            ?>
                                <div class="med-week__day <?= $on ? 'is-on' : '' ?>">
                                    <span class="med-week__name"><?= e($short) ?></span>
                                    <span class="med-week__time">
                                        <?= $on ? e($sched[$key]['from'] . '–' . $sched[$key]['to']) : 'Cerrado' ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-[12.5px] mt-2" style="color: var(--ink-quiet);">Sin horario indicado.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; endif; ?>
        </div>

        <!-- Assets -->
        <?php if (!empty($req['logo_url']) || !empty($req['portrait_url'])): ?>
            <div class="admin-card">
                <p class="text-[11px] font-bold uppercase tracking-[0.1em] mb-4" style="color: var(--ink-muted);">Archivos subidos</p>
                <div class="grid sm:grid-cols-2 gap-4">
                    <?php foreach (['Logo' => $req['logo_url'], 'Foto de perfil' => $req['portrait_url']] as $label => $path): ?>
                        <?php if (empty($path)) continue; ?>
                        <div class="med-asset">
                            <div class="med-asset__frame">
                                <img src="<?= e(med_asset_url($path)) ?>" alt="<?= e($label) ?>" loading="lazy">
                            </div>
                            <div class="med-asset__foot">
                                <span><?= e($label) ?></span>
                                <a href="<?= e(med_asset_url($path)) ?>" download target="_blank" rel="noopener noreferrer">Descargar</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- ══════════════ SIDEBAR ══════════════ -->
    <div class="flex flex-col gap-5">

        <!-- Plan -->
        <?php if ($plan): ?>
            <div class="admin-card med-plan-card">
                <p class="text-[11px] font-bold uppercase tracking-[0.1em] mb-2" style="color: var(--ink-muted);">Plan solicitado</p>
                <h3 class="text-[18px] font-medium" style="color: var(--ink);"><?= e($plan['name']) ?></h3>
                <p class="text-[24px] font-medium tracking-[-0.02em] mt-1" style="color: #0D9488;">
                    <?= e(MedicalSiteController::formatDop($plan['price'])) ?>
                </p>
                <p class="text-[12px] mt-0.5" style="color: var(--ink-muted);">
                    <?= e($plan['unit']) ?> · <?= e(MedicalSiteController::formatUsd($plan['price'])) ?>
                </p>
                <?php if (!empty($plan['price_monthly'])): ?>
                    <p class="text-[13px] font-semibold mt-2 pt-2 border-t border-[rgba(17,17,17,0.06)]" style="color: var(--ink);">
                        + <?= e(MedicalSiteController::formatDop($plan['price_monthly'])) ?> al mes
                        <span class="font-normal" style="color: var(--ink-muted);">de mantenimiento</span>
                    </p>
                <?php endif; ?>
                <div class="mt-3 pt-3 border-t border-[rgba(17,17,17,0.06)] text-[12.5px] leading-[1.6]" style="color: var(--ink-soft);">
                    <?= e($plan['pages']) ?><br>Entrega estimada: <?= e($plan['delivery']) ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Status -->
        <div class="admin-card">
            <p class="text-[11px] font-bold uppercase tracking-[0.1em] mb-3" style="color: var(--ink-muted);">Estado</p>
            <form method="POST" action="<?= url('/admin/medicos/' . $req['id'] . '/status') ?>" class="flex flex-col gap-2">
                <?= csrf_field() ?>
                <select name="status" class="admin-input">
                    <?php foreach ($labels as $key => $label): ?>
                        <option value="<?= e($key) ?>" <?= $req['status'] === $key ? 'selected' : '' ?>><?= e($label) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn-admin-primary w-full justify-center">Actualizar estado</button>
            </form>
        </div>

        <!-- Project details -->
        <div class="admin-card">
            <p class="text-[11px] font-bold uppercase tracking-[0.1em] mb-3" style="color: var(--ink-muted);">Detalles del proyecto</p>
            <div class="flex flex-col gap-2.5 text-[13px]">
                <div class="flex items-start justify-between gap-3">
                    <span style="color: var(--ink-muted);">Citas</span>
                    <span class="text-right" style="color: var(--ink);"><?= e(MedicalSiteController::BOOKING[$req['booking']] ?? '—') ?></span>
                </div>
                <div class="flex items-start justify-between gap-3">
                    <span style="color: var(--ink-muted);">Lanzamiento</span>
                    <span class="text-right" style="color: var(--ink);"><?= e(MedicalSiteController::LAUNCH[$req['launch_when']] ?? '—') ?></span>
                </div>
                <?php if (!empty($req['design_refs'])): ?>
                    <div class="pt-2.5 border-t border-[rgba(17,17,17,0.06)]">
                        <span class="block mb-1" style="color: var(--ink-muted);">Referencias de diseño</span>
                        <span class="break-all" style="color: var(--ink);"><?= e($req['design_refs']) ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($extras): ?>
                <p class="text-[11px] font-bold uppercase tracking-[0.1em] mt-4 mb-2.5" style="color: var(--ink-muted);">Funcionalidades pedidas</p>
                <div class="flex flex-wrap gap-1.5">
                    <?php foreach ($extras as $x): ?>
                        <span class="med-chip med-chip--sm"><?= e($x) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Actions -->
        <div class="admin-card">
            <p class="text-[11px] font-bold uppercase tracking-[0.1em] mb-3" style="color: var(--ink-muted);">Acciones</p>
            <a href="mailto:<?= e($req['email']) ?>?subject=<?= e(rawurlencode('Tu página web con KYROS · ' . $req['ref'])) ?>"
               class="btn-admin-primary w-full justify-center mb-2">Responder por correo</a>
            <?php $wa = preg_replace('/\D+/', '', (string) ($req['whatsapp'] ?: $req['phone'])); ?>
            <?php if ($wa): ?>
                <a href="https://wa.me/<?= e($wa) ?>" target="_blank" rel="noopener noreferrer"
                   class="btn-admin-ghost w-full justify-center">WhatsApp</a>
            <?php endif; ?>
        </div>

        <!-- Internal notes -->
        <div class="admin-card">
            <p class="text-[11px] font-bold uppercase tracking-[0.1em] mb-3" style="color: var(--ink-muted);">Notas internas</p>
            <form method="POST" action="<?= url('/admin/medicos/' . $req['id'] . '/notes') ?>">
                <?= csrf_field() ?>
                <textarea name="admin_notes" rows="5" class="admin-input mb-2" placeholder="Solo el equipo ve esto…"><?= e((string) ($req['admin_notes'] ?? '')) ?></textarea>
                <button type="submit" class="btn-admin-ghost w-full justify-center">Guardar notas</button>
            </form>
        </div>

        <!-- Mail delivery -->
        <div class="admin-card">
            <p class="text-[11px] font-bold uppercase tracking-[0.1em] mb-3" style="color: var(--ink-muted);">Entrega de correos</p>
            <div class="flex flex-col gap-2 text-[13px]">
                <div class="flex items-center justify-between">
                    <span style="color: var(--ink-muted);">Aviso al admin</span>
                    <span class="lead-mail <?= $req['mail_admin_ok'] ? 'is-ok' : 'is-fail' ?>"><?= $req['mail_admin_ok'] ? 'Enviado' : 'Falló' ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span style="color: var(--ink-muted);">Copia al médico</span>
                    <span class="lead-mail <?= $req['mail_client_ok'] ? 'is-ok' : 'is-fail' ?>"><?= $req['mail_client_ok'] ? 'Enviado' : 'Falló' ?></span>
                </div>
            </div>
            <?php if (!$req['mail_client_ok']): ?>
                <p class="text-[11px] mt-3 leading-[1.5]" style="color: var(--ink-quiet);">
                    El médico no recibió confirmación. Conviene responderle manualmente.
                </p>
            <?php endif; ?>
        </div>

        <!-- Origin -->
        <div class="admin-card">
            <p class="text-[11px] font-bold uppercase tracking-[0.1em] mb-2" style="color: var(--ink-muted);">Origen</p>
            <p class="text-[11px] leading-[1.6] break-all" style="color: var(--ink-quiet);">
                IP: <?= e((string) ($req['ip'] ?? '—')) ?><br>
                <?= e((string) ($req['user_agent'] ?? '—')) ?>
            </p>
        </div>

        <button type="button" class="text-[13px] font-medium hover:underline text-left" style="color: #DC2626;"
                data-modal-open="modal-confirm-delete"
                data-confirm-title="<?= e($req['ref'] . ' · ' . $name) ?>"
                data-confirm-action="<?= e(url('/admin/medicos/' . $req['id'] . '/delete')) ?>">
            Eliminar solicitud
        </button>
    </div>
</div>

<script>
/* Copy-to-clipboard for the content blocks — the production team pastes these
   straight into the site, so a one-click copy saves a lot of careful selecting. */
(() => {
  document.querySelectorAll('[data-copy]').forEach(btn => {
    btn.addEventListener('click', async () => {
      try {
        await navigator.clipboard.writeText(btn.dataset.copy || '');
        const original = btn.textContent;
        btn.textContent = 'Copiado ✓';
        btn.classList.add('is-done');
        setTimeout(() => { btn.textContent = original; btn.classList.remove('is-done'); }, 1600);
      } catch (_) {
        btn.textContent = 'No se pudo copiar';
        setTimeout(() => { btn.textContent = 'Copiar'; }, 1600);
      }
    });
  });
})();
</script>
