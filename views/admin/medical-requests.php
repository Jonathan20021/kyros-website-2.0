<?php
$labels  = MedicalRequest::STATUS_LABELS;
$plans   = MedicalSiteController::PLANS;
?>

<!-- Filters -->
<div class="flex flex-wrap items-center gap-3 mb-5">
    <div class="admin-search flex-1 min-w-[240px]">
        <?= icon('search', 'w-4 h-4') ?>
        <input type="text" id="med-search" placeholder="Buscar por nombre, especialidad, email o referencia…">
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <a href="<?= url('/admin/medicos') ?>" class="filter-pill <?= $filter === '' ? 'is-active' : '' ?>">Todas (<?= (int) $total ?>)</a>
        <?php foreach ($labels as $key => $label): ?>
            <a href="<?= url('/admin/medicos?status=' . $key) ?>" class="filter-pill <?= $filter === $key ? 'is-active' : '' ?>">
                <?= e($label) ?> (<?= (int) ($counts[$key] ?? 0) ?>)
            </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="admin-card p-0 overflow-hidden">
    <div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Ref</th>
                <th>Médico</th>
                <th>Especialidad</th>
                <th>Plan</th>
                <th>Consultorios</th>
                <th>Estado</th>
                <th>Recibido</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="med-tbody">
            <?php if (empty($requests)): ?>
                <tr><td colspan="8" class="text-center py-12">
                    <p class="mb-1" style="color: var(--ink-muted);">
                        <?= $filter ? 'No hay solicitudes con este estado.' : 'Aún no hay solicitudes de webs médicas.' ?>
                    </p>
                    <?php if (!$filter): ?>
                        <p class="text-[12px]" style="color: var(--ink-quiet);">
                            Las solicitudes de <a href="<?= url('/mi-pagina-medica') ?>" target="_blank" rel="noopener" class="underline">/mi-pagina-medica</a> aparecerán aquí.
                        </p>
                    <?php endif; ?>
                </td></tr>
            <?php else: foreach ($requests as $r):
                $name     = MedicalSiteController::displayName($r);
                $spec     = MedicalSiteController::specialtyLabel($r);
                $clinics  = MedicalRequest::decode($r['clinics'] ?? null);
                $planName = $plans[$r['plan']]['name'] ?? '—';
                $search   = strtolower($name . ' ' . $spec . ' ' . ($r['email'] ?? '') . ' ' . ($r['ref'] ?? '') . ' ' . ($r['city'] ?? ''));
            ?>
                <tr data-search="<?= e($search) ?>">
                    <td>
                        <a href="<?= url('/admin/medicos/' . $r['id']) ?>" class="font-mono text-[12px] font-semibold hover:text-[#0D9488] transition-colors" style="color: var(--ink);">
                            <?= e($r['ref']) ?>
                        </a>
                        <?php if ($r['status'] === 'nuevo'): ?>
                            <span class="lead-new-dot" title="Sin abrir"></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="flex items-center gap-2.5">
                            <?php if (!empty($r['portrait_url'])): ?>
                                <img src="<?= e(med_asset_url($r['portrait_url'])) ?>" alt="" class="med-avatar" loading="lazy">
                            <?php else: ?>
                                <span class="med-avatar med-avatar--empty"><?= e(mb_strtoupper(mb_substr($r['full_name'] ?: '?', 0, 1))) ?></span>
                            <?php endif; ?>
                            <span class="min-w-0">
                                <a href="<?= url('/admin/medicos/' . $r['id']) ?>" class="font-medium hover:text-[#0D9488] transition-colors block truncate" style="color: var(--ink);"><?= e($name) ?></a>
                                <span class="text-[12px] block truncate" style="color: var(--ink-muted);"><?= e($r['email']) ?></span>
                            </span>
                        </div>
                    </td>
                    <td><span class="text-[13px]"><?= e($spec) ?></span></td>
                    <td><span class="text-[13px]"><?= e($planName) ?></span></td>
                    <td>
                        <span class="text-[13px]" style="color: var(--ink-muted);">
                            <?= count($clinics) ?><?= count($clinics) === 1 ? ' sede' : ' sedes' ?>
                        </span>
                    </td>
                    <td><span class="med-badge med-badge--<?= e($r['status']) ?>"><?= e($labels[$r['status']] ?? $r['status']) ?></span></td>
                    <td>
                        <span class="text-[13px]" style="color: var(--ink-muted);"><?= e(date('d/m/Y H:i', strtotime((string) $r['created_at']))) ?></span>
                    </td>
                    <td class="text-right">
                        <a href="<?= url('/admin/medicos/' . $r['id']) ?>" class="text-[13px] font-medium hover:text-[#0D9488]" style="color: var(--ink);">Ver</a>
                    </td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
    </div>
</div>

<script>
(() => {
  const input = document.getElementById('med-search');
  const rows = [...document.querySelectorAll('#med-tbody tr[data-search]')];
  if (!input) return;
  input.addEventListener('input', () => {
    const q = input.value.trim().toLowerCase();
    rows.forEach(r => { r.hidden = q !== '' && !r.dataset.search.includes(q); });
  });
})();
</script>
