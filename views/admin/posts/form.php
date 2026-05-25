<?php $p = $post ?? []; $selectedCatId = (int)($p['category_id'] ?? 0); ?>

<!-- Quill WYSIWYG -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

<style>
    .ql-toolbar.ql-snow {
        border: 1px solid rgba(17,17,17,0.10);
        border-radius: 12px 12px 0 0;
        background: #FAFAFA;
        padding: 10px 12px;
    }
    .ql-container.ql-snow {
        border: 1px solid rgba(17,17,17,0.10);
        border-top: 0;
        border-radius: 0 0 12px 12px;
        min-height: 460px;
        font-size: 15.5px;
        font-family: 'Geist', 'Inter', sans-serif;
    }
    .ql-editor {
        min-height: 460px;
        line-height: 1.75;
        color: var(--ink);
        padding: 22px 24px;
    }
    .ql-editor.ql-blank::before { color: var(--ink-quiet); font-style: normal; }
    .ql-snow .ql-stroke { stroke: var(--ink-soft); }
    .ql-snow .ql-fill { fill: var(--ink-soft); }
    .ql-snow .ql-picker { color: var(--ink-soft); }
    .ql-snow .ql-toolbar button:hover .ql-stroke,
    .ql-snow .ql-toolbar .ql-active .ql-stroke { stroke: #F26522; }
    .ql-snow .ql-toolbar button:hover .ql-fill,
    .ql-snow .ql-toolbar .ql-active .ql-fill { fill: #F26522; }
    .ql-snow .ql-tooltip { z-index: 50; }

    .post-title-input {
        width: 100%;
        font-size: clamp(22px, 5vw, 36px);
        font-weight: 500;
        letter-spacing: -0.025em;
        color: var(--ink);
        border: 0;
        padding: 8px 0;
        outline: 0;
        background: transparent;
    }
    .post-title-input::placeholder { color: var(--ink-quiet); }
    .slug-display {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        color: var(--ink-muted);
        font-family: 'Geist Mono', monospace;
    }
    .slug-display code {
        background: #FAFAFA;
        border: 1px solid rgba(17,17,17,0.06);
        padding: 2px 8px;
        border-radius: 6px;
    }
    .editor-stats {
        display: inline-flex;
        align-items: center;
        gap: 14px;
        font-size: 12px;
        color: var(--ink-muted);
        font-family: 'Geist Mono', monospace;
    }
</style>

<form method="POST"
      action="<?= e($isEdit ? url('/admin/posts/' . $p['id'] . '/update') : url('/admin/posts/store')) ?>"
      enctype="multipart/form-data"
      id="post-form"
      class="grid lg:grid-cols-[1fr_320px] gap-5">
    <?= csrf_field() ?>

    <!-- ── Main editor column ─────────────────────────────── -->
    <div class="space-y-4">

        <div class="admin-card" style="padding: 22px 24px;">
            <input type="text" name="title" required value="<?= e($p['title'] ?? old('title')) ?>"
                   class="post-title-input" placeholder="Título del post" id="post-title">

            <div class="flex items-center justify-between gap-4 mt-3 pt-3 border-t border-stone-100 flex-wrap">
                <div class="slug-display">
                    <span style="color: var(--ink-quiet);">URL:</span>
                    <code id="slug-preview"><?= e($p['slug'] ?? 'auto-generado') ?></code>
                    <button type="button" id="edit-slug-btn" class="text-[12px] text-[#F26522] hover:underline">Editar</button>
                    <input type="text" name="slug" id="slug-input" value="<?= e($p['slug'] ?? '') ?>" class="admin-input hidden" style="max-width: 280px; font-size: 12.5px; padding: 4px 10px;">
                </div>
                <div class="editor-stats">
                    <span><span id="word-count">0</span> palabras</span>
                    <span>·</span>
                    <span><span id="read-time">1</span> min lectura</span>
                </div>
            </div>
        </div>

        <div class="admin-card" style="padding: 0; overflow: visible;">
            <div id="quill-editor"><?= ($p['content'] ?? '') ?></div>
            <input type="hidden" name="content" id="quill-content">
            <input type="hidden" name="reading_time" id="reading-time-input" value="<?= (int)($p['reading_time'] ?? 1) ?>">
        </div>

        <!-- Excerpt metabox -->
        <div class="metabox">
            <div class="metabox__header">
                <span class="metabox__title">Extracto</span>
            </div>
            <div class="metabox__body">
                <textarea name="excerpt" rows="3" class="admin-textarea" maxlength="500" placeholder="Resumen del post para previews y SEO (opcional, máx 500 caracteres)"><?= e($p['excerpt'] ?? old('excerpt')) ?></textarea>
                <p class="admin-help">Si lo dejas vacío, se usa el inicio del contenido.</p>
            </div>
        </div>

        <!-- SEO metabox with Google preview -->
        <div class="metabox">
            <div class="metabox__header">
                <span class="metabox__title">SEO</span>
                <span class="text-[11px]" style="color: var(--ink-muted);">Cómo aparece en Google</span>
            </div>
            <div class="metabox__body space-y-4">
                <div class="seo-preview">
                    <div class="seo-preview__url"><?= e(rtrim((string) env('APP_URL', ''), '/')) ?>/blog/<span id="seo-slug"><?= e($p['slug'] ?? 'auto-generado') ?></span></div>
                    <div class="seo-preview__title" id="seo-title">Título del post</div>
                    <div class="seo-preview__desc" id="seo-desc">El extracto o meta description aparecerá aquí.</div>
                </div>
                <div>
                    <label class="admin-label">Meta title <span class="font-normal" style="color: var(--ink-muted);">(deja vacío para usar el título)</span></label>
                    <input type="text" name="meta_title" id="meta-title" value="<?= e($p['meta_title'] ?? '') ?>" class="admin-input" maxlength="60" placeholder="Máx 60 caracteres">
                </div>
                <div>
                    <label class="admin-label">Meta description <span class="font-normal" style="color: var(--ink-muted);">(deja vacío para usar el extracto)</span></label>
                    <textarea name="meta_description" id="meta-desc" rows="2" class="admin-textarea" maxlength="160" placeholder="Máx 160 caracteres"><?= e($p['meta_description'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Right sidebar (WordPress-style metaboxes) ─────── -->
    <div class="space-y-4">

        <!-- PUBLISH BOX -->
        <div class="metabox">
            <div class="metabox__header">
                <span class="metabox__title">Publicación</span>
            </div>
            <div class="metabox__body space-y-3">
                <label class="flex items-center justify-between">
                    <span class="text-[13px]" style="color: var(--ink-soft);">Estado</span>
                    <select name="status" id="status-select" class="admin-select" style="width: auto; min-width: 140px;">
                        <option value="draft"     <?= (($p['status'] ?? 'draft') === 'draft') ? 'selected' : '' ?>>📝 Borrador</option>
                        <option value="published" <?= (($p['status'] ?? '') === 'published') ? 'selected' : '' ?>>🌍 Publicado</option>
                    </select>
                </label>
                <label class="flex items-center justify-between cursor-pointer">
                    <span class="text-[13px]" style="color: var(--ink-soft);">⭐ Destacado</span>
                    <input type="checkbox" name="featured" value="1" <?= !empty($p['featured']) ? 'checked' : '' ?> class="w-4 h-4 rounded" style="accent-color: var(--orange);">
                </label>
                <?php if ($isEdit && !empty($p['published_at'])): ?>
                    <p class="text-[11.5px] pt-2 border-t border-stone-100" style="color: var(--ink-muted);">
                        📅 Publicado <?= e(date('d M Y · H:i', strtotime($p['published_at']))) ?>
                    </p>
                <?php endif; ?>
                <?php if ($isEdit): ?>
                    <p class="text-[11.5px]" style="color: var(--ink-muted);">
                        👁 <?= (int)$p['views'] ?> vistas
                    </p>
                <?php endif; ?>
            </div>
            <div class="metabox__footer">
                <button type="submit" class="btn-admin-primary w-full justify-center">
                    <?= $isEdit ? '💾 Guardar cambios' : '✨ Crear post' ?>
                </button>
                <?php if ($isEdit && ($p['status'] ?? '') === 'published'): ?>
                    <a href="<?= url('/blog/' . $p['slug']) ?>" target="_blank" class="block text-center mt-2 text-[12px] text-[#F26522] hover:underline">Ver post público ↗</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- CATEGORY -->
        <div class="metabox" id="category-metabox">
            <div class="metabox__header">
                <span class="metabox__title">Categoría</span>
                <button type="button" data-modal-open="modal-new-category" class="text-[11px] font-medium text-[#F26522] hover:underline">+ Nueva</button>
            </div>
            <div class="metabox__body">
                <div class="check-list" id="category-list">
                    <label class="check-list__item">
                        <input type="radio" name="category_id" value="" <?= !$selectedCatId ? 'checked' : '' ?>>
                        <span style="color: var(--ink-muted);">— Sin categoría —</span>
                    </label>
                    <?php foreach ($categories as $cat): ?>
                        <label class="check-list__item">
                            <input type="radio" name="category_id" value="<?= (int)$cat['id'] ?>" <?= $selectedCatId === (int)$cat['id'] ? 'checked' : '' ?>>
                            <span class="check-list__color" style="background: <?= e($cat['color']) ?>;"></span>
                            <span><?= e($cat['name']) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- TAGS -->
        <div class="metabox">
            <div class="metabox__header">
                <span class="metabox__title">Etiquetas</span>
            </div>
            <div class="metabox__body">
                <div id="tags-container" class="flex flex-wrap gap-1.5 mb-2 min-h-[8px]"></div>
                <input type="text" id="tags-input" class="admin-input" style="font-size: 13px;" placeholder="Escribe + Enter para agregar">
                <input type="hidden" name="tags" id="tags-hidden" value="<?= e($p['tags'] ?? '') ?>">
                <p class="admin-help">Presiona Enter o coma para agregar cada etiqueta.</p>
            </div>
        </div>

        <!-- COVER IMAGE -->
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
                    <input type="file" name="cover_file" accept="image/*" class="hidden" onchange="window._previewCover(this)">
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
                    data-confirm-action="<?= url('/admin/posts/' . $p['id'] . '/delete') ?>"
                    class="w-full text-center py-2.5 text-[12.5px] text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                🗑 Eliminar post permanentemente
            </button>
        <?php endif; ?>
    </div>
</form>

<!-- ─── MODAL: Nueva categoría ─── -->
<div class="modal-overlay" id="modal-new-category" data-modal>
    <div class="modal-card" role="dialog" aria-labelledby="m-nc-title">
        <div class="modal-card__header">
            <div>
                <div class="modal-card__title" id="m-nc-title">Nueva categoría</div>
                <div class="modal-card__subtitle">Se añade y selecciona automáticamente.</div>
            </div>
            <button type="button" class="modal-card__close" data-modal-close aria-label="Cerrar">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></svg>
            </button>
        </div>
        <div class="modal-card__body">
            <div class="space-y-3">
                <div>
                    <label class="admin-label">Nombre</label>
                    <input type="text" id="new-cat-name" class="admin-input" placeholder="ej. Ciberseguridad" autofocus>
                </div>
                <div>
                    <label class="admin-label">Descripción (opcional)</label>
                    <input type="text" id="new-cat-desc" class="admin-input" placeholder="Breve descripción">
                </div>
                <div>
                    <label class="admin-label">Color</label>
                    <input type="color" id="new-cat-color" value="#F26522" class="h-10 w-full rounded-lg border border-stone-200 cursor-pointer">
                </div>
                <div id="new-cat-error" class="hidden text-[12.5px] text-red-600"></div>
            </div>
        </div>
        <div class="modal-card__footer">
            <button type="button" class="btn-admin-ghost" data-modal-close>Cancelar</button>
            <button type="button" class="btn-admin-primary" id="new-cat-save">Crear y seleccionar</button>
        </div>
    </div>
</div>

<script>
(() => {
    /* ── Slug auto-generation + edit ── */
    const slugify = (s) => (s || '').toLowerCase()
        .normalize('NFD').replace(/[̀-ͯ]/g, '')
        .replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    const titleInput = document.getElementById('post-title');
    const slugInput = document.getElementById('slug-input');
    const slugPreview = document.getElementById('slug-preview');
    const seoSlug = document.getElementById('seo-slug');
    const seoTitle = document.getElementById('seo-title');
    const seoDesc = document.getElementById('seo-desc');
    const metaTitleInput = document.getElementById('meta-title');
    const metaDescInput = document.getElementById('meta-desc');
    const excerptInput = document.querySelector('textarea[name="excerpt"]');
    const editSlugBtn = document.getElementById('edit-slug-btn');

    let slugManuallyEdited = !!slugInput.value;
    const updateSlug = (v) => {
        if (slugManuallyEdited && document.activeElement !== titleInput) return;
        const s = slugify(v) || 'auto-generado';
        slugInput.value = s === 'auto-generado' ? '' : s;
        slugPreview.textContent = s;
        if (seoSlug) seoSlug.textContent = s;
    };
    titleInput.addEventListener('input', e => {
        updateSlug(e.target.value);
        updateSeoPreview();
    });
    editSlugBtn.addEventListener('click', () => {
        slugInput.classList.remove('hidden');
        slugPreview.style.display = 'none';
        editSlugBtn.style.display = 'none';
        slugInput.focus();
        slugManuallyEdited = true;
    });
    slugInput.addEventListener('input', () => {
        const s = slugify(slugInput.value);
        slugInput.value = s;
        slugPreview.textContent = s;
        if (seoSlug) seoSlug.textContent = s;
    });

    /* ── SEO preview live ── */
    const updateSeoPreview = () => {
        const t = metaTitleInput.value.trim() || titleInput.value.trim() || 'Título del post';
        const d = metaDescInput.value.trim() || (excerptInput?.value || '').trim() || 'Sin descripción.';
        seoTitle.textContent = t.length > 60 ? t.slice(0, 57) + '…' : t;
        seoDesc.textContent  = d.length > 160 ? d.slice(0, 157) + '…' : d;
    };
    metaTitleInput.addEventListener('input', updateSeoPreview);
    metaDescInput.addEventListener('input', updateSeoPreview);
    excerptInput?.addEventListener('input', updateSeoPreview);
    updateSeoPreview();

    /* ── Tags input ── */
    const tagsContainer = document.getElementById('tags-container');
    const tagsInput = document.getElementById('tags-input');
    const tagsHidden = document.getElementById('tags-hidden');
    let tags = (tagsHidden.value || '').split(',').map(t => t.trim()).filter(Boolean);
    const renderTags = () => {
        tagsContainer.innerHTML = '';
        tags.forEach((tag, i) => {
            const chip = document.createElement('span');
            chip.className = 'tag-chip';
            chip.innerHTML = `${tag}<span class="tag-chip__remove" data-i="${i}">×</span>`;
            tagsContainer.appendChild(chip);
        });
        tagsHidden.value = tags.join(', ');
    };
    tagsContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('tag-chip__remove')) {
            tags.splice(parseInt(e.target.dataset.i, 10), 1);
            renderTags();
        }
    });
    tagsInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            const v = tagsInput.value.trim().replace(/,$/, '');
            if (v && !tags.includes(v)) { tags.push(v); renderTags(); }
            tagsInput.value = '';
        } else if (e.key === 'Backspace' && !tagsInput.value && tags.length) {
            tags.pop(); renderTags();
        }
    });
    renderTags();

    /* ── Cover preview ── */
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

    /* ── Quill init + word count ── */
    const wordCount = document.getElementById('word-count');
    const readTime = document.getElementById('read-time');
    const readTimeInput = document.getElementById('reading-time-input');
    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Empieza a escribir tu post...',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ align: [] }],
                ['blockquote', 'code-block'],
                ['link', 'image'],
                [{ color: [] }, { background: [] }],
                ['clean']
            ],
        },
    });
    const updateStats = () => {
        const text = quill.getText().trim();
        const w = text ? text.split(/\s+/).length : 0;
        const m = Math.max(1, Math.ceil(w / 200));
        if (wordCount) wordCount.textContent = w;
        if (readTime) readTime.textContent = m;
        if (readTimeInput) readTimeInput.value = m;
    };
    quill.on('text-change', updateStats);
    updateStats();
    document.getElementById('post-form').addEventListener('submit', () => {
        document.getElementById('quill-content').value = quill.root.innerHTML;
    });

    /* ── AJAX: create category from modal ── */
    const newCatSave = document.getElementById('new-cat-save');
    const newCatName = document.getElementById('new-cat-name');
    const newCatDesc = document.getElementById('new-cat-desc');
    const newCatColor = document.getElementById('new-cat-color');
    const newCatError = document.getElementById('new-cat-error');
    const csrfToken = document.querySelector('input[name="_csrf"]').value;
    const categoryList = document.getElementById('category-list');

    newCatSave.addEventListener('click', async () => {
        const name = newCatName.value.trim();
        if (!name) {
            newCatError.textContent = 'El nombre es obligatorio.';
            newCatError.classList.remove('hidden');
            return;
        }
        newCatSave.disabled = true;
        newCatSave.textContent = 'Creando…';
        try {
            const fd = new FormData();
            fd.append('_csrf', csrfToken);
            fd.append('name', name);
            fd.append('description', newCatDesc.value.trim());
            fd.append('color', newCatColor.value);
            const r = await fetch('<?= url('/admin/categories/ajax-store') ?>', { method: 'POST', body: fd });
            const data = await r.json();
            if (!data.ok) throw new Error(data.error || 'Error desconocido');
            // Add to the radio list and select it
            const label = document.createElement('label');
            label.className = 'check-list__item';
            label.innerHTML = `
                <input type="radio" name="category_id" value="${data.id}" checked>
                <span class="check-list__color" style="background:${data.color};"></span>
                <span>${data.name}</span>`;
            categoryList.appendChild(label);
            // Reset modal
            newCatName.value = ''; newCatDesc.value = ''; newCatColor.value = '#F26522';
            newCatError.classList.add('hidden');
            window.Modal.close(document.getElementById('modal-new-category'));
        } catch (err) {
            newCatError.textContent = err.message;
            newCatError.classList.remove('hidden');
        } finally {
            newCatSave.disabled = false;
            newCatSave.textContent = 'Crear y seleccionar';
        }
    });
    // Enter key in modal name field submits
    newCatName.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') { e.preventDefault(); newCatSave.click(); }
    });
})();
</script>
