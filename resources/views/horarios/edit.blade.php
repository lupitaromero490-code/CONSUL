@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="bi bi-pencil"></i> Editar Horario</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('horarios.update', $horario) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Día</label>
                        <select name="dia" class="form-select" required>
                            @foreach(['lunes','martes','miercoles','jueves','viernes','sabado','domingo'] as $dia)
                                <option value="{{ $dia }}" {{ $horario->dia == $dia ? 'selected' : '' }}>
                                    {{ ucfirst($dia) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hora inicio</label>
                            <input type="time" name="hora_inicio" class="form-control" value="{{ $horario->hora_inicio }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hora fin</label>
                            <input type="time" name="hora_fin" class="form-control" value="{{ $horario->hora_fin }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Margen entre citas (minutos)</label>
                        <input type="number" name="margen_minutos" class="form-control" value="{{ $horario->margen_minutos }}" min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="activo" class="form-select">
                            <option value="1" {{ $horario->activo ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ !$horario->activo ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('horarios.index') }}" class="btn btn-secondary">
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