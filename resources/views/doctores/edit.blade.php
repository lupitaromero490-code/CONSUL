@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="bi bi-pencil"></i> Editar Doctor</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('doctores.update', $doctor) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" name="name" class="form-control" value="{{ $doctor->user->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Especialidad</label>
                            <select name="especialidad_id" class="form-select" required>
                                @foreach($especialidades as $especialidad)
                                    <option value="{{ $especialidad->id }}" {{ $doctor->especialidad_id == $especialidad->id ? 'selected' : '' }}>
                                        {{ $especialidad->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cédula profesional</label>
                            <input type="text" name="cedula" class="form-control" value="{{ $doctor->cedula }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" value="{{ $doctor->telefono }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número de celular</label>
                        <input type="text" name="celular" class="form-control" value="{{ $doctor->celular }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3">{{ $doctor->descripcion }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="activo" class="form-select">
                            <option value="1" {{ $doctor->activo ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ !$doctor->activo ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('doctores.index') }}" class="btn btn-secondary">
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