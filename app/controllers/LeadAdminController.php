<?php
declare(strict_types=1);

// BriefController (option catalog) + Lead resolve through the autoloader —
// never require by path: the directory is lowercase and prod is case-sensitive.

class LeadAdminController
{
    public function index(): void
    {
        auth_require();
        $status = (string)($_GET['status'] ?? '');
        if ($status !== '' && !in_array($status, Lead::STATUSES, true)) {
            $status = '';
        }
        render_admin('leads', [
            'leads'    => Lead::all($status),
            'counts'   => Lead::countsByStatus(),
            'total'    => Lead::count(),
            'filter'   => $status,
        ], [
            'adminTitle'    => 'Solicitudes',
            'adminSubtitle' => 'Proyectos que llegan desde "Hablemos del proyecto"',
        ]);
    }

    public function show(string $id): void
    {
        auth_require();
        $lead = Lead::find((int) $id);
        if (!$lead) abort(404, 'Solicitud no encontrada');

        render_admin('lead-show', [
            'lead'     => $lead,
            'services' => BriefController::SERVICES,
            'budgets'  => null, // labels computed in the view via budgetLabelBoth()
            'timelines'=> BriefController::TIMELINES,
            'existing' => BriefController::EXISTING,
            'heardFrom'=> BriefController::HEARD_FROM,
        ], [
            'adminTitle'    => $lead['ref'] . ' · ' . $lead['name'],
            'adminSubtitle' => 'Detalle de la solicitud',
        ]);
    }

    public function updateStatus(string $id): void
    {
        auth_require();
        if (!csrf_check((string)($_POST['_csrf'] ?? ''))) {
            flash('admin_error', 'Sesión expirada. Inténtalo de nuevo.');
            redirect('/admin/leads/' . (int) $id);
        }
        Lead::setStatus((int) $id, (string)($_POST['status'] ?? ''));
        flash('admin_success', 'Estado actualizado.');
        redirect('/admin/leads/' . (int) $id);
    }

    public function updateNotes(string $id): void
    {
        auth_require();
        if (!csrf_check((string)($_POST['_csrf'] ?? ''))) {
            flash('admin_error', 'Sesión expirada. Inténtalo de nuevo.');
            redirect('/admin/leads/' . (int) $id);
        }
        Lead::setNotes((int) $id, trim((string)($_POST['admin_notes'] ?? '')));
        flash('admin_success', 'Notas guardadas.');
        redirect('/admin/leads/' . (int) $id);
    }

    public function destroy(string $id): void
    {
        auth_require();
        if (!csrf_check((string)($_POST['_csrf'] ?? ''))) {
            flash('admin_error', 'Sesión expirada. Inténtalo de nuevo.');
            redirect('/admin/leads');
        }
        Lead::delete((int) $id);
        flash('admin_success', 'Solicitud eliminada.');
        redirect('/admin/leads');
    }
}
