<?php
$labels = [
    'nuevo'      => 'Nuevos',
    'contactado' => 'Contactados',
    'propuesta'  => 'Propuesta',
    'ganado'     => 'Ganados',
    'perdido'    => 'Perdidos',
];
$svcLabels = BriefController::SERVICES;
?>

<!-- Filters -->
<div class="flex flex-wrap items-center gap-3 mb-5">
    <div class="admin-search flex-1 min-w-[240px]">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: var(--ink-muted);"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="lead-search" placeholder="Buscar por nombre, empresa, email o referencia…">
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <a href="<?= url('/admin/leads') ?>" class="filter-pill <?= $filter === '' ? 'is-active' : '' ?>">Todas (<?= (int) $total ?>)</a>
        <?php foreach ($labels as $key => $label): ?>
            <a href="<?= url('/admin/leads?status=' . $key) ?>" class="filter-pill <?= $filter === $key ? 'is-active' : '' ?>">
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
                <th>Cliente</th>
                <th>Servicios</th>
                <th>Presupuesto</th>
                <th>Estado</th>
                <th>Recibido</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="lead-tbody">
            <?php if (empty($leads)): ?>
                <tr><td colspan="7" class="text-center py-12">
                    <p class="mb-1" style="color: var(--ink-muted);">
                        <?= $filter ? 'No hay solicitudes con este estado.' : 'Aún no hay solicitudes.' ?>
                    </p>
                    <?php if (!$filter): ?>
                        <p class="text-[12px]" style="color: var(--ink-quiet);">Las solicitudes de "Hablemos del proyecto" aparecerán aquí.</p>
                    <?php endif; ?>
                </td></tr>
            <?php else: foreach ($leads as $l):
                $svcKeys = array_filter(explode(',', (string) $l['services']));
                $svcText = [];
                foreach ($svcKeys as $k) {
                    if (isset($svcLabels[$k])) $svcText[] = $svcLabels[$k][0];
                }
                $budget = BriefController::budgetLabel((string) $l['budget'], 'DOP');
                $search = strtolower(($l['name'] ?? '') . ' ' . ($l['company'] ?? '') . ' ' . ($l['email'] ?? '') . ' ' . ($l['ref'] ?? ''));
            ?>
                <tr data-search="<?= e($search) ?>">
                    <td>
                        <a href="<?= url('/admin/leads/' . $l['id']) ?>" class="font-mono text-[12px] font-semibold hover:text-[#F26522] transition-colors" style="color: var(--ink);">
                            <?= e($l['ref']) ?>
                        </a>
                        <?php if ($l['status'] === 'nuevo'): ?>
                            <span class="lead-new-dot" title="Sin abrir"></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= url('/admin/leads/' . $l['id']) ?>" class="font-medium hover:text-[#F26522] transition-colors" style="color: var(--ink);"><?= e($l['name']) ?></a>
                        <div class="text-[12px] mt-0.5" style="color: var(--ink-muted);">
                            <?= e($l['company'] ?: $l['email']) ?>
                        </div>
                    </td>
                    <td>
                        <span class="text-[13px]"><?= e($svcText ? implode(', ', $svcText) : '—') ?></span>
                    </td>
                    <td><span class="text-[13px]"><?= e($budget) ?></span></td>
                    <td><span class="lead-badge lead-badge--<?= e($l['status']) ?>"><?= e($l['status']) ?></span></td>
                    <td>
                        <span class="text-[13px]" style="color: var(--ink-muted);"><?= e(date('d/m/Y H:i', strtotime((string) $l['created_at']))) ?></span>
                    </td>
                    <td class="text-right">
                        <a href="<?= url('/admin/leads/' . $l['id']) ?>" class="text-[13px] font-medium hover:text-[#F26522]" style="color: var(--ink);">Ver</a>
                    </td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
    </div>
</div>

<script>
(() => {
  const input = document.getElementById('lead-search');
  const rows = [...document.querySelectorAll('#lead-tbody tr[data-search]')];
  if (!input) return;
  input.addEventListener('input', () => {
    const q = input.value.trim().toLowerCase();
    rows.forEach(r => { r.hidden = q !== '' && !r.dataset.search.includes(q); });
  });
})();
</script>
