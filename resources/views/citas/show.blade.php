@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm mb-3">
            <div class="card-header card-header-morado">
                <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Detalle de Cita</h5>
            </div>
            <div class="card-body">
                <p><strong>Paciente:</strong> {{ $cita->paciente->name }}</p>
                <p><strong>Doctor:</strong> {{ $cita->doctor->user->name }}</p>
                <p><strong>Especialidad:</strong> {{ $cita->doctor->especialidad->nombre }}</p>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</p>
                <p><strong>Hora:</strong> {{ $cita->hora_inicio }} - {{ $cita->hora_fin }}</p>
                <p><strong>Motivo:</strong> {{ $cita->motivo ?? '-' }}</p>
                <p><strong>Estado:</strong>
                    @if($cita->estado == 'pendiente')
                        <span class="badge bg-warning">Pendiente</span>
                    @elseif($cita->estado == 'confirmada')
                        <span class="badge bg-success">Confirmada</span>
                    @elseif($cita->estado == 'completada')
                        <span class="badge bg-primary">Completada</span>
                    @else
                        <span class="badge bg-danger">Cancelada</span>
                    @endif
                </p>

                @if(auth()->user()->esDoctor() && $cita->estado == 'confirmada' && !$cita->consulta)
                <a href="{{ route('consultas.create', $cita) }}" class="btn btn-primary w-100 mt-2">
                    <i class="bi bi-file-medical"></i> Iniciar Consulta
                </a>
                @endif
            </div>
        </div>
    </div>

    @if($cita->consulta)
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header card-header-morado">
                <h5 class="mb-0"><i class="bi bi-file-medical"></i> Consulta Registrada</h5>
            </div>
            <div class="card-body">
                <p><strong>Peso:</strong> {{ $cita->consulta->peso ?? '-' }} kg</p>
                <p><strong>Talla:</strong> {{ $cita->consulta->talla ?? '-' }} cm</p>
                <p><strong>Presión:</strong> {{ $cita->consulta->presion_arterial ?? '-' }}</p>
                <p><strong>Síntomas:</strong> {{ $cita->consulta->sintomas }}</p>
                <p><strong>Diagnóstico:</strong> {{ $cita->consulta->diagnostico }}</p>
                <p><strong>Receta:</strong> {{ $cita->consulta->receta ?? '-' }}</p>
                <p><strong>Notas:</strong> {{ $cita->consulta->notas_pendientes ?? '-' }}</p>
                <a href="{{ route('consultas.pdf', $cita->consulta) }}" class="btn btn-danger w-100">
                    <i class="bi bi-file-pdf"></i> Descargar PDF
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
<div class="mt-3">
    <a href="{{ route('citas.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Regresar
    </a>
</div>
@endsection