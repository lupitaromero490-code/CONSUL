@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header card-header-morado">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Nueva Especialidad</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('especialidades.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Duración de consulta (minutos)</label>
                        <input type="number" name="duracion_consulta" class="form-control" value="60" min="1" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="activo" class="form-check-input" value="1" checked>
                            <label class="form-check-label">Activo</label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('especialidades.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection