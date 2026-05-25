<?php
ob_start();
?>
<h1 class="font-medium text-[24px] tracking-tight mb-2" style="color: var(--ink);">Configuración inicial</h1>
<p class="text-[14px] leading-relaxed mb-6" style="color: var(--ink-soft);">
    Crea el usuario administrador. Esto solo se hace una vez.
</p>

<?php if (!empty($error)): ?>
    <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-[13px]"><?= e($error) ?></div>
<?php endif; ?>

<form method="POST" action="<?= url('/admin/install') ?>" class="space-y-4">
    <?= csrf_field() ?>
    <div>
        <label class="block text-[12px] font-semibold uppercase tracking-wider mb-1.5" style="color: var(--ink-soft);">Nombre</label>
        <input type="text" name="name" required value="<?= e(old('name')) ?>" class="w-full px-3.5 py-2.5 border border-[rgba(17,17,17,0.14)] rounded-lg text-[14px] focus:outline-none focus:border-[#F26522] focus:ring-2 focus:ring-[#F26522]/20">
    </div>
    <div>
        <label class="block text-[12px] font-semibold uppercase tracking-wider mb-1.5" style="color: var(--ink-soft);">Email</label>
        <input type="email" name="email" required value="<?= e(old('email')) ?>" class="w-full px-3.5 py-2.5 border border-[rgba(17,17,17,0.14)] rounded-lg text-[14px] focus:outline-none focus:border-[#F26522] focus:ring-2 focus:ring-[#F26522]/20">
    </div>
    <div>
        <label class="block text-[12px] font-semibold uppercase tracking-wider mb-1.5" style="color: var(--ink-soft);">Contraseña</label>
        <input type="password" name="password" required minlength="8" class="w-full px-3.5 py-2.5 border border-[rgba(17,17,17,0.14)] rounded-lg text-[14px] focus:outline-none focus:border-[#F26522] focus:ring-2 focus:ring-[#F26522]/20">
        <p class="text-[12px] mt-1.5" style="color: var(--ink-muted);">Mínimo 8 caracteres.</p>
    </div>
    <div>
        <label class="block text-[12px] font-semibold uppercase tracking-wider mb-1.5" style="color: var(--ink-soft);">Clave de instalación</label>
        <input type="text" name="install_key" required value="<?= e(old('install_key')) ?>" class="w-full px-3.5 py-2.5 border border-[rgba(17,17,17,0.14)] rounded-lg text-[14px] focus:outline-none focus:border-[#F26522] focus:ring-2 focus:ring-[#F26522]/20">
        <p class="text-[12px] mt-1.5" style="color: var(--ink-muted);">Definida en tu archivo <code class="px-1 bg-gray-100 rounded">.env</code> como <code class="px-1 bg-gray-100 rounded">ADMIN_INSTALL_KEY</code>.</p>
    </div>
    <button type="submit" class="w-full bg-[#111] hover:bg-[#222] text-white font-medium text-[14px] py-3 rounded-full mt-2 transition-colors">
        Crear admin & entrar →
    </button>
</form>
<?php
$content = ob_get_clean();
$title = 'Instalación · KYROS Admin';
require base_path('views/admin/auth-shell.php');
?>
