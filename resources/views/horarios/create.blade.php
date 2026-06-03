@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header card-header-morado">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Nuevo Horario</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('horarios.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                    <div class="mb-3">
                        <label class="form-label">Día</label>
                        <select name="dia" class="form-select" required>
                            <option value="">Seleccionar día...</option>
                            <option value="lunes">Lunes</option>
                            <option value="martes">Martes</option>
                            <option value="miercoles">Miércoles</option>
                            <option value="jueves">Jueves</option>
                            <option value="viernes">Viernes</option>
                            <option value="sabado">Sábado</option>
                            <option value="domingo">Domingo</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hora inicio</label>
                            <input type="time" name="hora_inicio" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hora fin</label>
                            <input type="time" name="hora_fin" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Margen entre citas (minutos)</label>
                        <input type="number" name="margen_minutos" class="form-control" value="15" min="0">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('horarios.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection