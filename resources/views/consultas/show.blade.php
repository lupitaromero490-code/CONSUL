@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header card-header-morado">
                <h5 class="mb-0"><i class="bi bi-file-medical"></i> Detalle de Consulta</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Paciente:</strong> {{ $consulta->cita->paciente->name }}</p>
                        <p><strong>Doctor:</strong> {{ $consulta->cita->doctor->user->name }}</p>
                        <p><strong>Especialidad:</strong> {{ $consulta->cita->doctor->especialidad->nombre }}</p>
                        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($consulta->cita->fecha)->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Peso:</strong> {{ $consulta->peso ?? '-' }} kg</p>
                        <p><strong>Talla:</strong> {{ $consulta->talla ?? '-' }} cm</p>
                        <p><strong>Presión arterial:</strong> {{ $consulta->presion_arterial ?? '-' }}</p>
                    </div>
                </div>
                <hr>
                <p><strong>Síntomas:</strong></p>
                <p>{{ $consulta->sintomas }}</p>
                <p><strong>Diagnóstico:</strong></p>
                <p>{{ $consulta->diagnostico }}</p>
                <p><strong>Receta:</strong></p>
                <p>{{ $consulta->receta ?? 'Sin receta' }}</p>
                <p><strong>Notas pendientes:</strong></p>
                <p>{{ $consulta->notas_pendientes ?? 'Sin notas' }}</p>

                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('consultas.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Regresar
                    </a>
                    <a href="{{ route('consultas.edit', $consulta) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                    <a href="{{ route('consultas.pdf', $consulta) }}" class="btn btn-danger">
                        <i class="bi bi-file-pdf"></i> Descargar PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection