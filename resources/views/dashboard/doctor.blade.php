@extends('layouts.app')

@section('content')
<h2 class="mb-4"><i class="bi bi-person-badge"></i> Bienvenido, {{ auth()->user()->name }}</h2>
<p class="text-muted">Especialidad: <strong>{{ $doctor->especialidad->nombre }}</strong></p>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card stat-card shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-calendar-day fs-2" style="color: var(--morado-medio)"></i>
                <h3 class="mt-2" style="color: var(--morado-medio)">{{ $citas->count() }}</h3>
                <small class="text-muted">Citas Hoy</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-hourglass-split fs-2" style="color: var(--morado-medio)"></i>
                <h3 class="mt-2" style="color: var(--morado-medio)">{{ $proximas->count() }}</h3>
                <small class="text-muted">Próximas Citas</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-clock fs-2" style="color: var(--morado-medio)"></i>
                <h3 class="mt-2" style="color: var(--morado-medio)">{{ $doctor->especialidad->duracion_consulta }} min</h3>
                <small class="text-muted">Duración Consulta</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header card-header-morado">
                <i class="bi bi-calendar-day"></i> Citas de Hoy
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th>Motivo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($citas as $cita)
                        <tr>
                            <td>{{ $cita->hora_inicio }}</td>
                            <td>{{ $cita->paciente->name }}</td>
                            <td>{{ $cita->motivo ?? '-' }}</td>
                            <td>
                                @if($cita->estado == 'pendiente')
                                    <span class="badge bg-warning">Pendiente</span>
                                @elseif($cita->estado == 'confirmada')
                                    <span class="badge bg-success">Confirmada</span>
                                @else
                                    <span class="badge bg-secondary">{{ $cita->estado }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No hay citas para hoy</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header card-header-morado">
                <i class="bi bi-calendar-check"></i> Próximas Citas
            </div>
            <div class="card-body">
                @forelse($proximas as $cita)
                <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded" style="background: var(--morado-suave)">
                    <div>
                        <strong>{{ $cita->paciente->name }}</strong><br>
                        <small>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }} - {{ $cita->hora_inicio }}</small>
                    </div>
                    <a href="{{ route('citas.show', $cita) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-eye"></i>
                    </a>
                </div>
                @empty
                <p class="text-muted text-center">No hay próximas citas</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection