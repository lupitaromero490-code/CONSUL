@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-clipboard2-pulse"></i> Especialidades</h2>
    <a href="{{ route('especialidades.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nueva Especialidad
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Duración (min)</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($especialidades as $especialidad)
                <tr>
                    <td>{{ $especialidad->id }}</td>
                    <td>{{ $especialidad->nombre }}</td>
                    <td>{{ $especialidad->descripcion ?? '-' }}</td>
                    <td>{{ $especialidad->duracion_consulta }} min</td>
                    <td>
                        @if($especialidad->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('especialidades.edit', $especialidad) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('especialidades.destroy', $especialidad) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar especialidad?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No hay especialidades registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection