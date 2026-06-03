@extends('layouts.app')

@section('content')
<h2 class="mb-4"><i class="bi bi-person"></i> Bienvenido, {{ auth()->user()->name }}</h2>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card stat-card shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-calendar-check fs-2" style="color: var(--morado-medio)"></i>
                <h3 class="mt-2" style="color: var(--morado-medio)">{{ $citas->count() }}</h3>
                <small class="text-muted">Mis Citas</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-hourglass-split fs-2" style="color: var(--morado-medio)"></i>
                <h3 class="mt-2" style="color: var(--morado-medio)">{{ $citas->where('estado', 'pendiente')->count() }}</h3>
                <small class="text-muted">Pendientes</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-check-circle fs-2" style="color: var(--morado-medio)"></i>
                <h3 class="mt-2" style="color: var(--morado-medio)">{{ $citas->where('estado', 'completada')->count() }}</h3>
                <small class="text-muted">Completadas</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header card-header-morado">
                <i class="bi bi-calendar-check"></i> Mis Últimas Citas
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Doctor</th>
                            <th>Especialidad</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($citas as $cita)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $cita->doctor->user->name }}</td>
                            <td>{{ $cita->doctor->especialidad->nombre }}</td>
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
                            <td colspan="4" class="text-center text-muted">No tienes citas registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header card-header-morado">
                <i class="bi bi-plus-circle"></i> Acciones
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('citas.create') }}" class="btn btn-primary">
                        <i class="bi bi-calendar-plus"></i> Agendar Nueva Cita
                    </a>
                    <a href="{{ route('citas.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-calendar-check"></i> Ver Todas mis Citas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection