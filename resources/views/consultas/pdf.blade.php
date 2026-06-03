<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta #{{ $consulta->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #4a0080; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { color: #4a0080; margin: 0; font-size: 20px; }
        .header p { margin: 3px 0; color: #666; }
        .seccion { margin-bottom: 15px; }
        .seccion h3 { color: #4a0080; border-bottom: 1px solid #9d4edd; padding-bottom: 3px; font-size: 13px; }
        .datos { display: flex; gap: 20px; }
        .dato { flex: 1; }
        .dato p { margin: 4px 0; }
        .recuadro { border: 1px solid #ddd; padding: 10px; border-radius: 5px; background: #f8f5ff; }
        .footer { text-align: center; margin-top: 30px; border-top: 1px solid #ddd; padding-top: 10px; color: #666; font-size: 10px; }
        .firma { margin-top: 40px; text-align: right; }
        .firma p { border-top: 1px solid #333; display: inline-block; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏥 CONSUL - Sistema de Agenda Médica</h1>
        <p>Reporte de Consulta Médica</p>
        <p>Fecha de emisión: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="seccion">
        <h3>INFORMACIÓN DEL PACIENTE</h3>
        <div class="recuadro">
            <div class="datos">
                <div class="dato">
                    <p><strong>Nombre:</strong> {{ $consulta->cita->paciente->name }}</p>
                    <p><strong>Correo:</strong> {{ $consulta->cita->paciente->email }}</p>
                </div>
                <div class="dato">
                    <p><strong>Fecha de consulta:</strong> {{ \Carbon\Carbon::parse($consulta->cita->fecha)->format('d/m/Y') }}</p>
                    <p><strong>Hora:</strong> {{ $consulta->cita->hora_inicio }} - {{ $consulta->cita->hora_fin }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="seccion">
        <h3>INFORMACIÓN DEL MÉDICO</h3>
        <div class="recuadro">
            <div class="datos">
                <div class="dato">
                    <p><strong>Doctor:</strong> {{ $consulta->cita->doctor->user->name }}</p>
                    <p><strong>Especialidad:</strong> {{ $consulta->cita->doctor->especialidad->nombre }}</p>
                </div>
                <div class="dato">
                    <p><strong>Cédula:</strong> {{ $consulta->cita->doctor->cedula }}</p>
                    <p><strong>Teléfono:</strong> {{ $consulta->cita->doctor->telefono ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="seccion">
        <h3>SIGNOS VITALES</h3>
        <div class="recuadro">
            <div class="datos">
                <div class="dato">
                    <p><strong>Peso:</strong> {{ $consulta->peso ?? '-' }} kg</p>
                    <p><strong>Talla:</strong> {{ $consulta->talla ?? '-' }} cm</p>
                </div>
                <div class="dato">
                    <p><strong>Presión arterial:</strong> {{ $consulta->presion_arterial ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="seccion">
        <h3>SÍNTOMAS</h3>
        <div class="recuadro">
            <p>{{ $consulta->sintomas }}</p>
        </div>
    </div>

    <div class="seccion">
        <h3>DIAGNÓSTICO</h3>
        <div class="recuadro">
            <p>{{ $consulta->diagnostico }}</p>
        </div>
    </div>

    <div class="seccion">
        <h3>RECETA MÉDICA</h3>
        <div class="recuadro">
            <p>{{ $consulta->receta ?? 'Sin receta médica' }}</p>
        </div>
    </div>

    @if($consulta->notas_pendientes)
    <div class="seccion">
        <h3>NOTAS PENDIENTES</h3>
        <div class="recuadro">
            <p>{{ $consulta->notas_pendientes }}</p>
        </div>
    </div>
    @endif

    <div class="firma">
        <p>{{ $consulta->cita->doctor->user->name }}<br>
        {{ $consulta->cita->doctor->especialidad->nombre }}<br>
        Cédula: {{ $consulta->cita->doctor->cedula }}</p>
    </div>

    <div class="footer">
        <p>CONSUL - Sistema de Agenda Médica | Documento generado automáticamente</p>
    </div>
</body>
</html>