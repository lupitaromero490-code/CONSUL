@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header card-header-morado">
                <h5 class="mb-0"><i class="bi bi-calendar-plus"></i> Agendar Cita</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('citas.store') }}" method="POST" id="formCita">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Especialidad</label>
                        <select id="especialidad_id" class="form-select">
                            <option value="">Seleccionar especialidad...</option>
                            @foreach($especialidades as $especialidad)
                                <option value="{{ $especialidad->id }}">{{ $especialidad->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="form-select" required>
                            <option value="">Primero selecciona una especialidad...</option>
                            @foreach($doctores as $doctor)
                                <option value="{{ $doctor->id }}" data-especialidad="{{ $doctor->especialidad_id }}">
                                    {{ $doctor->user->name }} - {{ $doctor->especialidad->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if(auth()->user()->esDoctor() || auth()->user()->esAdmin())
                    <div class="mb-3">
                        <label class="form-label">Paciente</label>
                        <select name="paciente_id" class="form-select" required>
                            <option value="">Seleccionar paciente...</option>
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}">{{ $paciente->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" id="fecha" name="fecha" class="form-control"
                               min="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3" id="div_horarios" style="display:none">
                        <label class="form-label">Hora disponible</label>
                        <select name="hora_inicio" id="hora_inicio" class="form-select" required>
                            <option value="">Cargando horarios...</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Motivo de la consulta</label>
                        <textarea name="motivo" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('citas.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Agendar Cita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$('#especialidad_id').change(function() {
    let especialidadId = $(this).val();
    $('#doctor_id option').each(function() {
        if ($(this).data('especialidad') == especialidadId || $(this).val() == '') {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
    $('#doctor_id').val('');
    $('#div_horarios').hide();
});

function cargarHorarios() {
    let doctorId = $('#doctor_id').val();
    let fecha = $('#fecha').val();

    if (doctorId && fecha) {
        $.ajax({
            url: '{{ route("citas.horarios") }}',
            type: 'GET',
            data: { doctor_id: doctorId, fecha: fecha },
            success: function(res) {
                $('#hora_inicio').empty();
                if (res.horarios.length > 0) {
                    let hora = res.horarios[0].hora_inicio;
                    let horaFin = res.horarios[0].hora_fin;
                    let duracion = res.duracion;
                    let ocupadas = res.ocupadas;

                    while (hora < horaFin) {
                        if (!ocupadas.includes(hora)) {
                            $('#hora_inicio').append(
                                $('<option>').val(hora).text(hora)
                            );
                        }
                        let [h, m] = hora.split(':').map(Number);
                        let totalMin = h * 60 + m + duracion + res.horarios[0].margen_minutos;
                        h = Math.floor(totalMin / 60);
                        m = totalMin % 60;
                        hora = String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0');
                    }
                    $('#div_horarios').show();
                } else {
                    $('#hora_inicio').append('<option>No hay horarios disponibles</option>');
                    $('#div_horarios').show();
                }
            }
        });
    }
}

$('#doctor_id').change(cargarHorarios);
$('#fecha').change(cargarHorarios);
</script>
@endsection