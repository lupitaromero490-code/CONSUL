@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Nuevo Turno</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('turnos.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Paciente</label>
                        <select name="paciente_id" class="form-select" required>
                            <option value="">Seleccionar paciente...</option>
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}">
                                    {{ $paciente->nombre }} {{ $paciente->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Servicio</label>
                        <select name="servicio_id" class="form-select" required>
                            <option value="">Seleccionar servicio...</option>
                            @foreach($servicios as $servicio)
                                <option value="{{ $servicio->id }}">
                                    {{ $servicio->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('turnos.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Asignar Turno
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection