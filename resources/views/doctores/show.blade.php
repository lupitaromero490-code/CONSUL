@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-header card-header-morado">
                <h5 class="mb-0"><i class="bi bi-person-badge"></i> Información del Doctor</h5>
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $doctor->user->name }}</p>
                <p><strong>Correo:</strong> {{ $doctor->user->email }}</p>
                <p><strong>Especialidad:</strong> {{ $doctor->especialidad->nombre }}</p>
                <p><strong>Cédula:</strong> {{ $doctor->cedula }}</p>
                <p><strong>Teléfono:</strong> {{ $doctor->telefono ?? '-' }}</p>
                <p><strong>Celular:</strong> {{ $doctor->celular ?? '-' }}</p>
                <p><strong>Descripción:</strong> {{ $doctor->descripcion ?? '-' }}</p>
                <p><strong>Estado:</strong>
                    @if($doctor->activo)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-secondary">Inactivo</span>
                    @endif
                </p>
                <a href="{{ route('doctores.edit', $doctor) }}" class="btn btn-warning w-100">
                    <i class="bi bi-pencil"></i> Editar
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header card-header-morado">
                <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Citas del Doctor</h5>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($citas as $cita)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $cita->hora_inicio }}</td>
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
                            <td colspan="4" class="text-center text-muted">No hay citas registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="mt-3">
    <a href="{{ route('doctores.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Regresar
    </a>
</div>
@endsection