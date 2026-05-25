<?php $p = $project ?? []; ?>

<style>
    .post-title-input {
        width: 100%;
        font-size: clamp(22px, 4.5vw, 32px);
        font-weight: 500;
        letter-spacing: -0.025em;
        color: var(--ink);
        border: 0;
        padding: 8px 0;
        outline: 0;
        background: transparent;
    }
    .post-title-input::placeholder { color: var(--ink-quiet); }
</style>

<form method="POST"
      action="<?= e($isEdit ? url('/admin/projects/' . $p['id'] . '/update') : url('/admin/projects/store')) ?>"
      enctype="multipart/form-data"
      id="project-form"
      class="grid lg:grid-cols-[1fr_320px] gap-5">
    <?= csrf_field() ?>

    <!-- Main column -->
    <div class="space-y-4">
        <div class="admin-card" style="padding: 22px 24px;">
            <input type="text" name="title" id="proj-title" required value="<?= e($p['title'] ?? old('title')) ?>"
                   class="post-title-input" placeholder="Título del proyecto">
            <div class="flex items-center justify-between gap-4 mt-3 pt-3 border-t border-stone-100 flex-wrap">
                <div class="slug-display flex items-center gap-2 text-[12.5px]" style="color: var(--ink-muted); font-family: 'Geist Mono', monospace;">
                    <span style="color: var(--ink-quiet);">URL:</span>
                    <code id="slug-preview" style="background: #FAFAFA; border: 1px solid rgba(17,17,17,0.06); padding: 2px 8px; border-radius: 6px;"><?= e($p['slug'] ?? 'auto-generado') ?></code>
                    <button type="button" id="edit-slug-btn" class="text-[12px] text-[#F26522] hover:underline">Editar</button>
                    <input type="text" name="slug" id="slug-input" value="<?= e($p['slug'] ?? '') ?>" class="admin-input hidden" style="max-width: 280px; font-size: 12.5px; padding: 4px 10px;">
                </div>
            </div>
        </div>

        <!-- Description metabox -->
        <div class="metabox">
            <div class="metabox__header">
                <span class="metabox__title">Descripción corta</span>
                <span class="text-[11px]" style="color: var(--ink-muted);">Aparece en el card del home</span>
            </div>
            <div class="metabox__body">
                <textarea name="description" rows="2" class="admin-textarea" placeholder="Modernización completa del sistema de información hospitalaria…"><?= e($p['description'] ?? old('description')) ?></textarea>
            </div>
        </div>

        <!-- Content (HTML) -->
        <div class="metabox">
            <div class="metabox__header">
                <span class="metabox__title">Contenido detallado</span>
                <span class="text-[11px]" style="color: var(--ink-muted);">HTML permitido</span>
            </div>
            <div class="metabox__body">
                <textarea name="content" rows="14" class="admin-textarea" placeholder="<p>Detalle del proyecto, retos, soluciones, resultados…</p>" style="font-family: 'Geist Mono', monospace; font-size: 13px;"><?= e($p['content'] ?? old('content')) ?></textarea>
                <p class="admin-help">Aparece en la página pública /proyectos/&lt;slug&gt;.</p>
            </div>
        </div>

        <!-- Metadata grid -->
        <div class="metabox">
            <div class="metabox__header">
                <span class="metabox__title">Datos del proyecto</span>
            </div>
            <div class="metabox__body grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="admin-label">Cliente</label>
                    <input type="text" name="client" value="<?= e($p['client'] ?? old('client')) ?>" class="admin-input" placeholder="Hospital Las Colinas">
                </div>
                <div>
                    <label class="admin-label">Categoría</label>
                    <input type="text" name="category" value="<?= e($p['category'] ?? old('category')) ?>" class="admin-input" placeholder="Salud / Banca / Retail">
                </div>
                <div>
                    <label class="admin-label">Métrica destacada</label>
                    <input type="text" name="metric" value="<?= e($p['metric'] ?? old('metric')) ?>" class="admin-input" placeholder="40% menos fricción operativa">
                </div>
                <div>
                    <label class="admin-label">URL externa</label>
                    <input type="url" name="external_url" value="<?= e($p['external_url'] ?? old('external_url')) ?>" class="admin-input" placeholder="https://…">
                </div>
                <div>
                    <label class="admin-label">Tags</label>
                    <input type="text" name="tags" value="<?= e($p['tags'] ?? old('tags')) ?>" class="admin-input" placeholder="HIS, hospital, salud">
                </div>
                <div>
                    <label class="admin-label">Año</label>
                    <input type="text" name="year" value="<?= e($p['year'] ?? old('year') ?: date('Y')) ?>" class="admin-input">
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-4">
        <!-- PUBLISH -->
        <div class="metabox">
            <div class="metabox__header">
                <span class="metabox__title">Publicación</span>
            </div>
            <div class="metabox__body space-y-3">
                <label class="flex items-center justify-between">
                    <span class="text-[13px]" style="color: var(--ink-soft);">Estado</span>
                    <select name="status" class="admin-select" style="width: auto; min-width: 140px;">
                        <option value="published" <?= (($p['status'] ?? 'published') === 'published') ? 'selected' : '' ?>>🌍 Publicado</option>
                        <option value="draft"     <?= (($p['status'] ?? '') === 'draft') ? 'selected' : '' ?>>📝 Borrador</option>
                    </select>
                </label>
                <label class="flex items-center justify-between cursor-pointer">
                    <span class="text-[13px]" style="color: var(--ink-soft);">⭐ Destacado en landing</span>
                    <input type="checkbox" name="featured" value="1" <?= !empty($p['featured']) ? 'checked' : '' ?> class="w-4 h-4 rounded" style="accent-color: var(--orange);">
                </label>
                <label class="flex items-center justify-between">
                    <span class="text-[13px]" style="color: var(--ink-soft);">Orden</span>
                    <input type="number" name="sort_order" value="<?= (int)($p['sort_order'] ?? 0) ?>" class="admin-input" style="width: 80px; padding: 6px 10px;">
                </label>
            </div>
            <div class="metabox__footer">
                <button type="submit" class="btn-admin-primary w-full justify-center">
                    <?= $isEdit ? '💾 Guardar cambios' : '✨ Crear proyecto' ?>
                </button>
                <?php if ($isEdit): ?>
                    <a href="<?= url('/proyectos/' . $p['slug']) ?>" target="_blank" class="block text-center mt-2 text-[12px] text-[#F26522] hover:underline">Ver proyecto público ↗</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- THEME -->
        <div class="metabox">
            <div class="metabox__header">
                <span class="metabox__title">Tema visual del card</span>
            </div>
            <div class="metabox__body">
                <select name="color_theme" class="admin-select">
                    <option value="dark"   <?= (($p['color_theme'] ?? 'dark') === 'dark') ? 'selected' : '' ?>>🌑 Oscuro</option>
                    <option value="light"  <?= (($p['color_theme'] ?? '') === 'light') ? 'selected' : '' ?>>☁️ Claro</option>
                    <option value="orange" <?= (($p['color_theme'] ?? '') === 'orange') ? 'selected' : '' ?>>🟠 Naranja</option>
                </select>
                <p class="admin-help">Color de fondo del card en la landing.</p>
            </div>
        </div>

        <!-- COVER -->
        <div class="metabox">
            <div class="metabox__header">
                <span class="metabox__title">Imagen de portada</span>
            </div>
            <div class="metabox__body">
                <?php if (!empty($p['cover_image'])): ?>
                    <div class="relative mb-3 rounded-lg overflow-hidden border border-stone-200">
                        <img src="<?= e($p['cover_image']) ?>" alt="" class="w-full block" style="max-height: 180px; object-fit: cover;">
                    </div>
                <?php endif; ?>
                <label class="file-drop block">
                    <input type="file" name="cover_file" accept="image/*" class="hidden" id="cover-input" onchange="window._previewCover(this)">
                    <div id="cover-drop">
                        <div class="text-[22px] mb-1">📷</div>
                        <p class="text-[12.5px] font-medium" style="color: var(--ink);">Subir imagen</p>
                        <p class="text-[11px] mt-0.5" style="color: var(--ink-muted);">JPG, PNG, WebP · máx 12MB</p>
                    </div>
                    <img id="cover-preview" class="file-drop__preview hidden" alt="Preview">
                </label>
                <div class="mt-3">
                    <input type="url" name="cover_image_url" value="<?= e($p['cover_image'] ?? '') ?>" class="admin-input" placeholder="O pega URL…" style="font-size: 12.5px;">
                </div>
            </div>
        </div>

        <?php if ($isEdit): ?>
            <button type="button"
                    data-modal-open="modal-confirm-delete"
                    data-confirm-title="<?= e($p['title']) ?>"
                    data-confirm-action="<?= url('/admin/projects/' . $p['id'] . '/delete') ?>"
                    class="w-full text-center py-2.5 text-[12.5px] text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                🗑 Eliminar proyecto permanentemente
            </button>
        <?php endif; ?>
    </div>
</form>

<script>
(() => {
    const slugify = (s) => (s || '').toLowerCase()
        .normalize('NFD').replace(/[̀-ͯ]/g, '')
        .replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    const titleInput = document.getElementById('proj-title');
    const slugInput = document.getElementById('slug-input');
    const slugPreview = document.getElementById('slug-preview');
    const editSlugBtn = document.getElementById('edit-slug-btn');
    let manual = !!slugInput.value;
    titleInput.addEventListener('input', e => {
        if (!manual) {
            const s = slugify(e.target.value) || 'auto-generado';
            slugInput.value = s === 'auto-generado' ? '' : s;
            slugPreview.textContent = s;
        }
    });
    editSlugBtn.addEventListener('click', () => {
        slugInput.classList.remove('hidden');
        slugPreview.style.display = 'none';
        editSlugBtn.style.display = 'none';
        slugInput.focus();
        manual = true;
    });
    slugInput.addEventListener('input', () => {
        const s = slugify(slugInput.value);
        slugInput.value = s;
        slugPreview.textContent = s;
    });

    window._previewCover = (input) => {
        const file = input.files?.[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('cover-preview');
            img.src = e.target.result;
            img.classList.remove('hidden');
            document.getElementById('cover-drop').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    };
})();
</script>
