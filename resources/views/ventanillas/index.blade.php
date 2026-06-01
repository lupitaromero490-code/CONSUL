@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-window"></i> Ventanillas</h2>
    <a href="{{ route('ventanillas.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nueva Ventanilla
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Número</th>
                    <th>Estado</th>
                    <th>Operador</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventanillas as $ventanilla)
                <tr>
                    <td>{{ $ventanilla->id }}</td>
                    <td>{{ $ventanilla->nombre }}</td>
                    <td>{{ $ventanilla->numero }}</td>
                    <td>
                        @if($ventanilla->estado == 'activa')
                            <span class="badge bg-success">Activa</span>
                        @elseif($ventanilla->estado == 'en_pausa')
                            <span class="badge bg-warning">En Pausa</span>
                        @else
                            <span class="badge bg-secondary">Inactiva</span>
                        @endif
                    </td>
                    <td>{{ $ventanilla->operador->name ?? 'Sin asignar' }}</td>
                    <td>
                        <a href="{{ route('ventanillas.edit', $ventanilla) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('ventanillas.destroy', $ventanilla) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar ventanilla?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No hay ventanillas registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection