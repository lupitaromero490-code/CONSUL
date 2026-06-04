@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="bi bi-pencil"></i> Actualizar Estado de Cita</h5>
            </div>
            <div class="card-body">
                <p><strong>Paciente:</strong> {{ $cita->paciente->name }}</p>
                <p><strong>Doctor:</strong> {{ $cita->doctor->user->name }}</p>
                <p><strong>Especialidad:</strong> {{ $cita->doctor->especialidad->nombre }}</p>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</p>
                <p><strong>Hora:</strong> {{ $cita->hora_inicio }} - {{ $cita->hora_fin }}</p>

                <form action="{{ route('citas.update', $cita) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select" required>
                            @if(auth()->user()->esAdmin() || auth()->user()->esDoctor())
                                <option value="pendiente" {{ $cita->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="confirmada" {{ $cita->estado == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                <option value="completada" {{ $cita->estado == 'completada' ? 'selected' : '' }}>Completada</option>
                                <option value="cancelada" {{ $cita->estado == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            @else
                                <option value="cancelada" {{ $cita->estado == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            @endif
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('citas.index') }}" class="btn btn-secondary">
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