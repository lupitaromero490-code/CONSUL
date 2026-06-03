@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-calendar-check"></i> Citas</h2>
    <a href="{{ route('citas.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nueva Cita
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Doctor</th>
                    <th>Paciente</th>
                    <th>Motivo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($citas as $cita)
                <tr>
                    <td>{{ $cita->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $cita->hora_inicio }}</td>
                    <td>{{ $cita->doctor->user->name }}</td>
                    <td>{{ $cita->paciente->name }}</td>
                    <td>{{ $cita->motivo ?? '-' }}</td>
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
                    <td>
                        <a href="{{ route('citas.show', $cita) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('citas.edit', $cita) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('citas.destroy', $cita) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Cancelar cita?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No hay citas registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection