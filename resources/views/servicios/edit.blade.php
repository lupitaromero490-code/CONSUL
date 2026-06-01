@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="bi bi-pencil"></i> Editar Servicio</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('servicios.update', $servicio) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $servicio->nombre }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3">{{ $servicio->descripcion }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Duración promedio (minutos)</label>
                        <input type="number" name="duracion_promedio" class="form-control" value="{{ $servicio->duracion_promedio }}" min="1" required>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="activo" class="form-check-input" value="1" {{ $servicio->activo ? 'checked' : '' }}>
                            <label class="form-check-label">Activo</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('servicios.index') }}" class="btn btn-secondary">
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