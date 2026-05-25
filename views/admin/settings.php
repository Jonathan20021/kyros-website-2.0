<form method="POST" action="<?= url('/admin/settings') ?>" class="max-w-2xl space-y-5">
    <?= csrf_field() ?>

    <div class="admin-card">
        <h2 class="font-medium text-[16px] mb-1" style="color: var(--ink);">Sitio</h2>
        <p class="text-[13px] mb-5" style="color: var(--ink-muted);">Información general que aparece en el sitio público.</p>
        <div class="space-y-4">
            <div>
                <label class="admin-label">Título del sitio</label>
                <input type="text" name="site_title" value="<?= e($siteTitle) ?>" class="admin-input">
            </div>
            <div>
                <label class="admin-label">Descripción del sitio</label>
                <textarea name="site_description" rows="2" class="admin-textarea"><?= e($siteDescription) ?></textarea>
            </div>
            <div>
                <label class="admin-label">Intro del blog</label>
                <input type="text" name="blog_intro" value="<?= e($blogIntro) ?>" class="admin-input">
                <p class="admin-help">Aparece en la cabecera de /blog.</p>
            </div>
        </div>
    </div>

    <div class="admin-card">
        <h2 class="font-medium text-[16px] mb-1" style="color: var(--ink);">Contacto</h2>
        <p class="text-[13px] mb-5" style="color: var(--ink-muted);">Datos de contacto que se muestran en footer y CTA.</p>
        <div class="space-y-4">
            <div>
                <label class="admin-label">Email</label>
                <input type="email" name="contact_email" value="<?= e($contactEmail) ?>" class="admin-input">
            </div>
            <div>
                <label class="admin-label">Teléfono / WhatsApp</label>
                <input type="text" name="contact_phone" value="<?= e($contactPhone) ?>" class="admin-input">
            </div>
        </div>
    </div>

    <button type="submit" class="bg-[#F26522] hover:bg-[#E05A1A] text-white font-medium text-[14px] px-6 py-3 rounded-full transition">
        Guardar configuración
    </button>
</form>
