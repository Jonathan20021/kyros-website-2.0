<?php
$p = $project ?? [];
$categories = $categories ?? [];
$tagSuggest = $tagSuggest ?? [];

// Open "Detalles opcionales" by default only when it already holds something —
// on a brand-new project it stays collapsed so the form reads as "título +
// imagen + descripción y listo".
$hasDetails = !empty($p['content']) || !empty($p['client']) || !empty($p['category'])
    || !empty($p['metric']) || !empty($p['external_url']) || !empty($p['tags'])
    || (($p['color_theme'] ?? 'dark') !== 'dark');
?>

<form method="POST"
      action="<?= e($isEdit ? url('/admin/projects/' . $p['id'] . '/update') : url('/admin/projects/store')) ?>"
      enctype="multipart/form-data"
      id="project-form"
      class="grid lg:grid-cols-[1fr_320px] gap-5">
    <?= csrf_field() ?>

    <!-- Main column -->
    <div class="space-y-4">
        <!-- Título -->
        <div class="admin-card" style="padding: 22px 24px;">
            <input type="text" name="title" id="proj-title" required value="<?= e($p['title'] ?? old('title')) ?>"
                   class="post-title-input" placeholder="Título del proyecto" autofocus>
            <div class="flex items-center justify-between gap-4 mt-3 pt-3 border-t border-stone-100 flex-wrap">
                <div class="slug-display flex items-center gap-2 text-[12.5px]" style="color: var(--ink-muted); font-family: 'Geist Mono', monospace;">
                    <span style="color: var(--ink-quiet);">URL:</span>
                    <code id="slug-preview" style="background: #FAFAFA; border: 1px solid rgba(17,17,17,0.06); padding: 2px 8px; border-radius: 6px;"><?= e($p['slug'] ?? 'auto-generado') ?></code>
                    <button type="button" id="edit-slug-btn" class="text-[12px] text-[#F26522] hover:underline">Editar</button>
                    <input type="text" name="slug" id="slug-input" value="<?= e($p['slug'] ?? '') ?>" class="admin-input hidden" style="max-width: 280px; font-size: 12.5px; padding: 4px 10px;">
                </div>
            </div>
        </div>

        <!-- Descripción — lo esencial -->
        <div class="metabox metabox--accent">
            <div class="metabox__header">
                <span class="metabox__title">Descripción corta</span>
                <span class="text-[11px]" style="color: var(--ink-muted);">Aparece en el card del home</span>
            </div>
            <div class="metabox__body">
                <textarea name="description" rows="3" class="admin-textarea" placeholder="Modernización completa del sistema de información hospitalaria…"><?= e($p['description'] ?? old('description')) ?></textarea>
                <p class="admin-help">✓ Con el título, esta descripción y una imagen ya puedes publicar. Todo lo de abajo es opcional.</p>
            </div>
        </div>

        <!-- Detalles opcionales — plegado por defecto -->
        <details class="metabox metabox--fold" <?= $hasDetails ? 'open' : '' ?>>
            <summary class="metabox__header metabox__header--summary">
                <span class="flex items-center gap-2">
                    <svg class="fold-chevron" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    <span class="metabox__title">Detalles opcionales</span>
                </span>
                <span class="text-[11px]" style="color: var(--ink-muted);">Contenido, cliente, categoría, tags…</span>
            </summary>

            <div class="metabox__fold-inner">
                <!-- Contenido: editor visual -->
                <div class="p-4 border-b border-stone-100">
                    <label class="admin-label">Contenido detallado</label>
                    <div class="rte" data-rte>
                        <div class="rte__toolbar" data-rte-toolbar>
                            <button type="button" class="rte__btn" data-cmd="bold" title="Negrita"><b>B</b></button>
                            <button type="button" class="rte__btn" data-cmd="italic" title="Cursiva"><i>I</i></button>
                            <button type="button" class="rte__btn" data-cmd="formatBlock" data-val="h3" title="Subtítulo">H</button>
                            <span class="rte__sep"></span>
                            <button type="button" class="rte__btn" data-cmd="insertUnorderedList" title="Lista con viñetas">•—</button>
                            <button type="button" class="rte__btn" data-cmd="insertOrderedList" title="Lista numerada">1.</button>
                            <button type="button" class="rte__btn" data-cmd="createLink" title="Insertar enlace">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                            </button>
                            <button type="button" class="rte__btn" data-cmd="removeFormat" title="Quitar formato">⨯</button>
                            <span class="rte__spacer"></span>
                            <button type="button" class="rte__btn rte__btn--mode" data-rte-toggle title="Alternar HTML">&lt;/&gt;</button>
                        </div>
                        <div class="rte__editor" contenteditable="true" data-rte-editor
                             data-placeholder="Escribe o pega el detalle del proyecto: retos, solución y resultados. Se ve con formato, sin escribir código."></div>
                        <textarea name="content" class="rte__source" data-rte-source hidden><?= e($p['content'] ?? old('content')) ?></textarea>
                    </div>
                    <p class="admin-help">Aparece en la página pública /proyectos/&lt;slug&gt;. Puedes pegar texto de un documento y se ordena solo en párrafos.</p>
                </div>

                <!-- Datos del proyecto -->
                <div class="p-4 grid sm:grid-cols-2 gap-4 border-b border-stone-100">
                    <div>
                        <label class="admin-label">Cliente</label>
                        <input type="text" name="client" value="<?= e($p['client'] ?? old('client')) ?>" class="admin-input" placeholder="Hospital Las Colinas">
                    </div>
                    <div>
                        <label class="admin-label">Categoría</label>
                        <input type="text" name="category" list="proj-categories" value="<?= e($p['category'] ?? old('category')) ?>" class="admin-input" placeholder="Salud / Banca / Retail" autocomplete="off">
                        <?php if ($categories): ?>
                            <datalist id="proj-categories">
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= e($cat) ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label class="admin-label">Métrica destacada</label>
                        <input type="text" name="metric" value="<?= e($p['metric'] ?? old('metric')) ?>" class="admin-input" placeholder="40% menos fricción operativa">
                    </div>
                    <div>
                        <label class="admin-label">URL externa</label>
                        <input type="url" name="external_url" value="<?= e($p['external_url'] ?? old('external_url')) ?>" class="admin-input" placeholder="https://…">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="admin-label">Tags</label>
                        <input type="text" name="tags" id="tags-input" value="<?= e($p['tags'] ?? old('tags')) ?>" class="admin-input" placeholder="HIS, hospital, salud">
                        <?php if ($tagSuggest): ?>
                            <div class="tag-suggest" data-tag-suggest>
                                <?php foreach ($tagSuggest as $tag): ?>
                                    <button type="button" class="tag-suggest__chip" data-tag="<?= e($tag) ?>">+ <?= e($tag) ?></button>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label class="admin-label">Año</label>
                        <input type="text" name="year" value="<?= e($p['year'] ?? old('year') ?: date('Y')) ?>" class="admin-input">
                    </div>
                    <div>
                        <label class="admin-label">Tema visual del card</label>
                        <select name="color_theme" class="admin-select">
                            <option value="dark"   <?= (($p['color_theme'] ?? 'dark') === 'dark') ? 'selected' : '' ?>>🌑 Oscuro</option>
                            <option value="light"  <?= (($p['color_theme'] ?? '') === 'light') ? 'selected' : '' ?>>☁️ Claro</option>
                            <option value="orange" <?= (($p['color_theme'] ?? '') === 'orange') ? 'selected' : '' ?>>🟠 Naranja</option>
                        </select>
                    </div>
                </div>
            </div>
        </details>
    </div>

    <!-- Sidebar -->
    <div class="space-y-4">
        <!-- PUBLICAR -->
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

        <!-- PORTADA -->
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
    /* ── Slug auto-generate ─────────────────────────────────── */
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

    /* ── Cover preview ──────────────────────────────────────── */
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

    /* ── Visual editor (RTE) ────────────────────────────────────
       The <textarea name="content"> stays the source of truth that
       the form submits; the contenteditable mirrors into it. A "</>"
       toggle swaps to raw-HTML editing so nothing is ever locked away
       and a broken editor can always be bypassed. */
    const rte = document.querySelector('[data-rte]');
    if (rte) {
        const editor  = rte.querySelector('[data-rte-editor]');
        const source  = rte.querySelector('[data-rte-source]');
        const toolbar = rte.querySelector('[data-rte-toolbar]');
        const toggle  = rte.querySelector('[data-rte-toggle]');
        const form    = document.getElementById('project-form');
        let htmlMode  = false;

        const esc = (s) => s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');

        // Seed the editor from whatever the server rendered into the textarea.
        editor.innerHTML = source.value.trim();

        // Keep the textarea in step. Treat a visually-empty editor as truly
        // empty so we never store "<br>" or "<p></p>" as content.
        const sync = () => {
            if (htmlMode) return;
            source.value = editor.textContent.trim() === '' ? '' : editor.innerHTML;
        };
        editor.addEventListener('input', sync);

        // Toolbar commands via execCommand — deprecated but universal and
        // dependency-free, which is the right trade for a small admin editor.
        toolbar.querySelectorAll('[data-cmd]').forEach(btn => {
            btn.addEventListener('mousedown', (e) => e.preventDefault()); // keep selection
            btn.addEventListener('click', () => {
                const cmd = btn.dataset.cmd;
                editor.focus();
                if (cmd === 'createLink') {
                    const url = prompt('Dirección del enlace:', 'https://');
                    if (url) document.execCommand('createLink', false, url);
                } else if (cmd === 'formatBlock') {
                    document.execCommand('formatBlock', false, btn.dataset.val);
                } else {
                    document.execCommand(cmd, false, null);
                }
                sync();
                refreshActive();
            });
        });

        // Reflect active formatting on the toolbar.
        const refreshActive = () => {
            [['bold','bold'],['italic','italic'],['insertUnorderedList','insertUnorderedList'],['insertOrderedList','insertOrderedList']]
              .forEach(([cmd, q]) => {
                const b = toolbar.querySelector(`[data-cmd="${cmd}"]`);
                if (b) { try { b.classList.toggle('is-active', document.queryCommandState(q)); } catch (_) {} }
              });
        };
        editor.addEventListener('keyup', refreshActive);
        editor.addEventListener('mouseup', refreshActive);

        // Paste as clean paragraphs: pull text/plain, split on blank lines,
        // escape it, wrap each block in <p>. Turns a pasted document into tidy
        // HTML instead of the span-and-style soup a rich paste would inject.
        editor.addEventListener('paste', (e) => {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text/plain');
            if (!text) return;
            const html = text.split(/\n{2,}/).map(b => b.trim()).filter(Boolean)
                .map(b => '<p>' + esc(b).replace(/\n/g, '<br>') + '</p>').join('');
            document.execCommand('insertHTML', false, html || esc(text));
            sync();
        });

        // Swap between the visual editor and raw HTML.
        toggle.addEventListener('click', () => {
            htmlMode = !htmlMode;
            if (htmlMode) {
                source.value = editor.textContent.trim() === '' ? '' : editor.innerHTML;
                source.hidden = false;
                editor.hidden = true;
                toolbar.querySelectorAll('[data-cmd]').forEach(b => b.disabled = true);
            } else {
                editor.innerHTML = source.value.trim();
                source.hidden = true;
                editor.hidden = false;
                toolbar.querySelectorAll('[data-cmd]').forEach(b => b.disabled = false);
            }
            toggle.classList.toggle('is-active', htmlMode);
        });

        // Final safety sync — a paste or command right before submit is covered.
        form?.addEventListener('submit', sync);
    }

    /* ── Tag suggestion chips ───────────────────────────────── */
    const tagsInput = document.getElementById('tags-input');
    const tagWrap = document.querySelector('[data-tag-suggest]');
    if (tagsInput && tagWrap) {
        const current = () => tagsInput.value.split(',').map(t => t.trim().toLowerCase()).filter(Boolean);
        const mark = () => {
            const have = current();
            tagWrap.querySelectorAll('[data-tag]').forEach(chip => {
                chip.classList.toggle('is-added', have.includes(chip.dataset.tag.toLowerCase()));
            });
        };
        tagWrap.querySelectorAll('[data-tag]').forEach(chip => {
            chip.addEventListener('click', () => {
                const tag = chip.dataset.tag;
                const have = current();
                if (have.includes(tag.toLowerCase())) {
                    // Toggle off: drop it from the field.
                    const kept = tagsInput.value.split(',').map(t => t.trim()).filter(t => t && t.toLowerCase() !== tag.toLowerCase());
                    tagsInput.value = kept.join(', ');
                } else {
                    const v = tagsInput.value.trim().replace(/,\s*$/, '');
                    tagsInput.value = (v ? v + ', ' : '') + tag;
                }
                mark();
                tagsInput.focus();
            });
        });
        tagsInput.addEventListener('input', mark);
        mark();
    }
})();
</script>
