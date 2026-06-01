@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="bi bi-pencil"></i> Editar Ventanilla</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('ventanillas.update', $ventanilla) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $ventanilla->nombre }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Número</label>
                        <input type="number" name="numero" class="form-control" value="{{ $ventanilla->numero }}" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select" required>
                            <option value="activa" {{ $ventanilla->estado == 'activa' ? 'selected' : '' }}>Activa</option>
                            <option value="inactiva" {{ $ventanilla->estado == 'inactiva' ? 'selected' : '' }}>Inactiva</option>
                            <option value="en_pausa" {{ $ventanilla->estado == 'en_pausa' ? 'selected' : '' }}>En Pausa</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Operador</label>
                        <select name="user_id" class="form-select">
                            <option value="">Sin asignar</option>
                            @foreach($operadores as $operador)
                                <option value="{{ $operador->id }}" {{ $ventanilla->user_id == $operador->id ? 'selected' : '' }}>
                                    {{ $operador->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('ventanillas.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle"></i> Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection