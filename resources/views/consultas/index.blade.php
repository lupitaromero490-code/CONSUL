@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-file-medical"></i> Consultas</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Paciente</th>
                    <th>Doctor</th>
                    <th>Fecha</th>
                    <th>Diagnóstico</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consultas as $consulta)
                <tr>
                    <td>{{ $consulta->id }}</td>
                    <td>{{ $consulta->cita->paciente->name }}</td>
                    <td>{{ $consulta->cita->doctor->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($consulta->cita->fecha)->format('d/m/Y') }}</td>
                    <td>{{ \Str::limit($consulta->diagnostico, 50) }}</td>
                    <td>
                        <a href="{{ route('consultas.show', $consulta) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('consultas.edit', $consulta) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="{{ route('consultas.pdf', $consulta) }}" class="btn btn-sm btn-danger">
                            <i class="bi bi-file-pdf"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No hay consultas registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection