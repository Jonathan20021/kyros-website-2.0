<div class="flex items-center justify-between mb-5">
    <p class="text-[13.5px]" style="color: var(--ink-muted);">Las categorías se usan para organizar los posts del blog.</p>
    <button type="button" data-modal-open="modal-new-cat" class="btn-admin-primary">+ Nueva categoría</button>
</div>

<div class="admin-card p-0 overflow-hidden">
    <div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Slug</th>
                <th>Orden</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($categories)): ?>
                <tr><td colspan="5" class="text-center py-12">
                    <p class="mb-3" style="color: var(--ink-muted);">Aún no hay categorías. Crea la primera.</p>
                    <button type="button" data-modal-open="modal-new-cat" class="btn-admin-primary">+ Nueva categoría</button>
                </td></tr>
            <?php else: foreach ($categories as $c): ?>
                <tr>
                    <td style="width: 48px;">
                        <span class="inline-block w-6 h-6 rounded-full" style="background: <?= e($c['color']) ?>;"></span>
                    </td>
                    <td>
                        <div class="font-medium" style="color: var(--ink);"><?= e($c['name']) ?></div>
                        <?php if (!empty($c['description'])): ?>
                            <div class="text-[12px] mt-0.5" style="color: var(--ink-muted);"><?= e($c['description']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td><code class="text-[12px] px-1.5 py-0.5 bg-stone-100 rounded"><?= e($c['slug']) ?></code></td>
                    <td><?= (int)$c['sort_order'] ?></td>
                    <td class="text-right">
                        <button type="button"
                                data-modal-open="modal-edit-cat-<?= (int)$c['id'] ?>"
                                class="text-[13px] font-medium hover:text-[#F26522]" style="color: var(--ink);">Editar</button>
                        <button type="button"
                                data-modal-open="modal-confirm-delete"
                                data-confirm-title="<?= e($c['name']) ?>"
                                data-confirm-action="<?= url('/admin/categories/' . $c['id'] . '/delete') ?>"
                                class="text-[13px] text-red-600 hover:underline ml-3">Borrar</button>

                        <!-- Edit modal per row -->
                        <div class="modal-overlay" id="modal-edit-cat-<?= (int)$c['id'] ?>" data-modal>
                            <div class="modal-card" role="dialog">
                                <div class="modal-card__header">
                                    <div>
                                        <div class="modal-card__title">Editar categoría</div>
                                        <div class="modal-card__subtitle"><?= e($c['name']) ?></div>
                                    </div>
                                    <button type="button" class="modal-card__close" data-modal-close>
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></svg>
                                    </button>
                                </div>
                                <form method="POST" action="<?= url('/admin/categories/' . $c['id'] . '/update') ?>">
                                    <?= csrf_field() ?>
                                    <div class="modal-card__body space-y-3">
                                        <div>
                                            <label class="admin-label">Nombre</label>
                                            <input type="text" name="name" value="<?= e($c['name']) ?>" required class="admin-input">
                                        </div>
                                        <div>
                                            <label class="admin-label">Slug</label>
                                            <input type="text" name="slug" value="<?= e($c['slug']) ?>" class="admin-input">
                                        </div>
                                        <div>
                                            <label class="admin-label">Descripción</label>
                                            <input type="text" name="description" value="<?= e($c['description'] ?? '') ?>" class="admin-input">
                                        </div>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="admin-label">Color</label>
                                                <input type="color" name="color" value="<?= e($c['color']) ?>" class="h-10 w-full rounded-lg border border-stone-200 cursor-pointer">
                                            </div>
                                            <div>
                                                <label class="admin-label">Orden</label>
                                                <input type="number" name="sort_order" value="<?= (int)$c['sort_order'] ?>" class="admin-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-card__footer">
                                        <button type="button" class="btn-admin-ghost" data-modal-close>Cancelar</button>
                                        <button type="submit" class="btn-admin-primary">Guardar cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
    </div>
</div>

<!-- ─── MODAL: Nueva categoría ─── -->
<div class="modal-overlay" id="modal-new-cat" data-modal>
    <div class="modal-card" role="dialog" aria-labelledby="m-cat-title">
        <div class="modal-card__header">
            <div>
                <div class="modal-card__title" id="m-cat-title">Nueva categoría</div>
                <div class="modal-card__subtitle">Para agrupar tus posts del blog.</div>
            </div>
            <button type="button" class="modal-card__close" data-modal-close aria-label="Cerrar">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" action="<?= url('/admin/categories/store') ?>">
            <?= csrf_field() ?>
            <div class="modal-card__body space-y-3">
                <div>
                    <label class="admin-label">Nombre *</label>
                    <input type="text" name="name" required autofocus class="admin-input" placeholder="ej. Ciberseguridad">
                </div>
                <div>
                    <label class="admin-label">Descripción (opcional)</label>
                    <input type="text" name="description" class="admin-input" placeholder="Breve descripción">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="admin-label">Color</label>
                        <input type="color" name="color" value="#F26522" class="h-10 w-full rounded-lg border border-stone-200 cursor-pointer">
                    </div>
                    <div>
                        <label class="admin-label">Orden</label>
                        <input type="number" name="sort_order" value="0" class="admin-input">
                    </div>
                </div>
            </div>
            <div class="modal-card__footer">
                <button type="button" class="btn-admin-ghost" data-modal-close>Cancelar</button>
                <button type="submit" class="btn-admin-primary">Crear categoría</button>
            </div>
        </form>
    </div>
</div>
