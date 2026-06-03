@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-person-badge"></i> Doctores</h2>
    <a href="{{ route('doctores.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Doctor
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Especialidad</th>
                    <th>Cédula</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($doctores as $doctor)
                <tr>
                    <td>{{ $doctor->id }}</td>
                    <td>{{ $doctor->user->name }}</td>
                    <td>{{ $doctor->especialidad->nombre }}</td>
                    <td>{{ $doctor->cedula }}</td>
                    <td>{{ $doctor->telefono ?? '-' }}</td>
                    <td>
                        @if($doctor->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('doctores.show', $doctor) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('doctores.edit', $doctor) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('doctores.destroy', $doctor) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar doctor?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No hay doctores registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection