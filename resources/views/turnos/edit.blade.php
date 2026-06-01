@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="bi bi-pencil"></i> Actualizar Turno #{{ $turno->numero_turno }}</h5>
            </div>
            <div class="card-body">
                <p><strong>Paciente:</strong> {{ $turno->paciente->nombre }} {{ $turno->paciente->apellido }}</p>
                <p><strong>Servicio:</strong> {{ $turno->servicio->nombre }}</p>

                <form action="{{ route('turnos.update', $turno) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select" required>
                            <option value="esperando" {{ $turno->estado == 'esperando' ? 'selected' : '' }}>Esperando</option>
                            <option value="en_atencion" {{ $turno->estado == 'en_atencion' ? 'selected' : '' }}>En Atención</option>
                            <option value="completado" {{ $turno->estado == 'completado' ? 'selected' : '' }}>Completado</option>
                            <option value="ausente" {{ $turno->estado == 'ausente' ? 'selected' : '' }}>Ausente</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ventanilla</label>
                        <select name="ventanilla_id" class="form-select">
                            <option value="">Sin ventanilla</option>
                            @foreach($ventanillas as $ventanilla)
                                <option value="{{ $ventanilla->id }}" {{ $turno->ventanilla_id == $ventanilla->id ? 'selected' : '' }}>
                                    {{ $ventanilla->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('turnos.index') }}" class="btn btn-secondary">
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