@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Nueva Ventanilla</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('ventanillas.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Número</label>
                        <input type="number" name="numero" class="form-control" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Operador</label>
                        <select name="user_id" class="form-select">
                            <option value="">Sin asignar</option>
                            @foreach($operadores as $operador)
                                <option value="{{ $operador->id }}">{{ $operador->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('ventanillas.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection