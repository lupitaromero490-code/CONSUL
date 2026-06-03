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
    <div class="col-md-6">
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
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header card-header-morado">
                <i class="bi bi-info-circle"></i> Información del Sistema
            </div>
            <div class="card-body">
                <p><strong>Sistema:</strong> CONSUL v1.0</p>
                <p><strong>Framework:</strong> Laravel 13</p>
                <p><strong>Base de datos:</strong> MySQL</p>
                <p><strong>Fecha:</strong> {{ now()->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection