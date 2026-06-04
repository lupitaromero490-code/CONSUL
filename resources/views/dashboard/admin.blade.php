@extends('layouts.app')

@section('content')
<h2 class="mb-4"><i class="bi bi-speedometer2"></i> Panel de Administración</h2>

<div class="row g-3 mb-4">
    <div class="col-md-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-person-badge fs-2 text-purple"></i>
                <h3 class="mt-2" style="color: var(--morado-medio)">{{ $datos['total_doctores'] }}</h3>
                <small class="text-muted">Doctores</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-people fs-2" style="color: var(--morado-medio)"></i>
                <h3 class="mt-2" style="color: var(--morado-medio)">{{ $datos['total_pacientes'] }}</h3>
                <small class="text-muted">Pacientes</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-calendar-check fs-2" style="color: var(--morado-medio)"></i>
                <h3 class="mt-2" style="color: var(--morado-medio)">{{ $datos['total_citas'] }}</h3>
                <small class="text-muted">Total Citas</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-calendar-day fs-2" style="color: var(--morado-medio)"></i>
                <h3 class="mt-2" style="color: var(--morado-medio)">{{ $datos['citas_hoy'] }}</h3>
                <small class="text-muted">Citas Hoy</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-hourglass-split fs-2" style="color: var(--morado-medio)"></i>
                <h3 class="mt-2" style="color: var(--morado-medio)">{{ $datos['citas_pendientes'] }}</h3>
                <small class="text-muted">Pendientes</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-clipboard2-pulse fs-2" style="color: var(--morado-medio)"></i>
                <h3 class="mt-2" style="color: var(--morado-medio)">{{ $datos['especialidades'] }}</h3>
                <small class="text-muted">Especialidades</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header card-header-morado">
                <i class="bi bi-person-badge"></i> Accesos Rápidos
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('doctores.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Registrar Doctor
                    </a>
                    <a href="{{ route('especialidades.create') }}" class="btn btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Nueva Especialidad
                    </a>
                    <a href="{{ route('citas.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-calendar-check"></i> Ver todas las Citas
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header card-header-morado">
                <i class="bi bi-calendar-day"></i> Citas de Hoy
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Doctor</th>
                            <th>Paciente</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\Cita::with(['doctor.user','paciente'])
                            ->whereDate('fecha', today())
                            ->orderBy('hora_inicio')
                            ->take(5)->get() as $cita)
                        <tr>
                            <td>{{ $cita->hora_inicio }}</td>
                            <td>{{ $cita->doctor->user->name }}</td>
                            <td>{{ $cita->paciente->name }}</td>
                            <td>
                                @if($cita->estado == 'pendiente')
                                    <span class="badge bg-warning">Pendiente</span>
                                @elseif($cita->estado == 'confirmada')
                                    <span class="badge bg-success">Confirmada</span>
                                @elseif($cita->estado == 'completada')
                                    <span class="badge bg-primary">Completada</span>
                                @else
                                    <span class="badge bg-danger">Cancelada</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">No hay citas para hoy</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-3">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header card-header-morado">
                <i class="bi bi-database"></i> Estado de Bases de Datos
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <i class="bi bi-database fs-2" style="color: var(--morado-medio)"></i>
                        <h5 class="mt-2">MySQL (Principal)</h5>
                        @if($conexiones['mysql'] == 'activo')
                            <span class="badge bg-success fs-6">Activo</span>
                        @else
                            <span class="badge bg-danger fs-6">Inactivo</span>
                        @endif
                    </div>
                    <div class="col-md-6 text-center">
                        <i class="bi bi-database-fill fs-2" style="color: var(--morado-medio)"></i>
                        <h5 class="mt-2">PostgreSQL (Réplica)</h5>
                        @if($conexiones['pgsql'] == 'activo')
                            <span class="badge bg-success fs-6">Activo</span>
                        @else
                            <span class="badge bg-danger fs-6">Inactivo</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection