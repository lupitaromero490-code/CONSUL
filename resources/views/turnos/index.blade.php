@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-ticket-perforated"></i> Turnos</h2>
    <a href="{{ route('turnos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Turno
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#Turno</th>
                    <th>Paciente</th>
                    <th>Servicio</th>
                    <th>Estado</th>
                    <th>Hora Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($turnos as $turno)
                <tr>
                    <td><strong>{{ $turno->numero_turno }}</strong></td>
                    <td>{{ $turno->paciente->nombre }} {{ $turno->paciente->apellido }}</td>
                    <td>{{ $turno->servicio->nombre }}</td>
                    <td>
                        @if($turno->estado == 'esperando')
                            <span class="badge bg-warning">Esperando</span>
                        @elseif($turno->estado == 'en_atencion')
                            <span class="badge bg-primary">En Atención</span>
                        @elseif($turno->estado == 'completado')
                            <span class="badge bg-success">Completado</span>
                        @else
                            <span class="badge bg-danger">Ausente</span>
                        @endif
                    </td>
                    <td>{{ $turno->hora_registro }}</td>
                    <td>
                        <a href="{{ route('turnos.edit', $turno) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('turnos.destroy', $turno) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar turno?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No hay turnos registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection