@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-clipboard2-pulse"></i> Servicios</h2>
    <a href="{{ route('servicios.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Servicio
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-primary">
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
                @forelse($servicios as $servicio)
                <tr>
                    <td>{{ $servicio->id }}</td>
                    <td>{{ $servicio->nombre }}</td>
                    <td>{{ $servicio->descripcion ?? '-' }}</td>
                    <td>{{ $servicio->duracion_promedio }} min</td>
                    <td>
                        @if($servicio->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('servicios.edit', $servicio) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('servicios.destroy', $servicio) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar servicio?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No hay servicios registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection