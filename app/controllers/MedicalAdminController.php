<?php
declare(strict_types=1);

// MedicalRequest + MedicalSiteController (the option catalog) resolve through
// the autoloader — never require by path: the directory is lowercase and prod
// is case-sensitive.

class MedicalAdminController
{
    public function index(): void
    {
        auth_require();
        $status = (string)($_GET['status'] ?? '');
        if ($status !== '' && !in_array($status, MedicalRequest::STATUSES, true)) {
            $status = '';
        }
        render_admin('medical-requests', [
            'requests' => MedicalRequest::all($status),
            'counts'   => MedicalRequest::countsByStatus(),
            'total'    => MedicalRequest::count(),
            'filter'   => $status,
        ], [
            'adminTitle'    => 'Webs médicas',
            'adminSubtitle' => 'Solicitudes de páginas para médicos y especialistas',
        ]);
    }

    public function show(string $id): void
    {
        auth_require();
        $req = MedicalRequest::find((int) $id);
        if (!$req) abort(404, 'Solicitud no encontrada');

        render_admin('medical-request-show', [
            'req'     => $req,
            'clinics' => MedicalRequest::decode($req['clinics'] ?? null),
            'socials' => MedicalRequest::decode($req['socials'] ?? null),
        ], [
            'adminTitle'    => $req['ref'] . ' · ' . MedicalSiteController::displayName($req),
            'adminSubtitle' => 'Detalle de la solicitud de web médica',
        ]);
    }

    public function updateStatus(string $id): void
    {
        auth_require();
        if (!csrf_check((string)($_POST['_csrf'] ?? ''))) {
            flash('error', 'Sesión expirada. Inténtalo de nuevo.');
            redirect('/admin/medicos/' . (int) $id);
        }
        MedicalRequest::setStatus((int) $id, (string)($_POST['status'] ?? ''));
        flash('success', 'Estado actualizado.');
        redirect('/admin/medicos/' . (int) $id);
    }

    public function updateNotes(string $id): void
    {
        auth_require();
        if (!csrf_check((string)($_POST['_csrf'] ?? ''))) {
            flash('error', 'Sesión expirada. Inténtalo de nuevo.');
            redirect('/admin/medicos/' . (int) $id);
        }
        MedicalRequest::setNotes((int) $id, trim((string)($_POST['admin_notes'] ?? '')));
        flash('success', 'Notas guardadas.');
        redirect('/admin/medicos/' . (int) $id);
    }

    public function destroy(string $id): void
    {
        auth_require();
        if (!csrf_check((string)($_POST['_csrf'] ?? ''))) {
            flash('error', 'Sesión expirada. Inténtalo de nuevo.');
            redirect('/admin/medicos');
        }
        MedicalRequest::delete((int) $id);
        flash('success', 'Solicitud eliminada.');
        redirect('/admin/medicos');
    }
}
