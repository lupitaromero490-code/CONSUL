@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header card-header-morado">
                <h5 class="mb-0"><i class="bi bi-file-medical"></i> Registrar Consulta</h5>
            </div>
            <div class="card-body">
                <div class="alert" style="background: var(--morado-suave)">
                    <strong>Paciente:</strong> {{ $cita->paciente->name }} |
                    <strong>Doctor:</strong> {{ $cita->doctor->user->name }} |
                    <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                </div>

                <form action="{{ route('consultas.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="cita_id" value="{{ $cita->id }}">

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Peso (kg)</label>
                            <input type="number" name="peso" class="form-control" step="0.1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Talla (cm)</label>
                            <input type="number" name="talla" class="form-control" step="0.1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Presión arterial</label>
                            <input type="text" name="presion_arterial" class="form-control" placeholder="120/80">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Síntomas <span class="text-danger">*</span></label>
                        <textarea name="sintomas" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Diagnóstico <span class="text-danger">*</span></label>
                        <textarea name="diagnostico" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Receta médica</label>
                        <textarea name="receta" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notas pendientes</label>
                        <textarea name="notas_pendientes" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('citas.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Guardar Consulta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection