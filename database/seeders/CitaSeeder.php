<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Consulta;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;

class CitaSeeder extends Seeder
{
    public function run(): void
    {
        $doctores = Doctor::all();
        $pacientes = User::where('rol', 'paciente')->get();
        $estados = ['pendiente', 'confirmada', 'completada', 'cancelada'];
        $motivos = [
            'Revisión general', 'Dolor de cabeza', 'Control mensual',
            'Fiebre', 'Dolor de espalda', 'Revisión de rutina',
            'Consulta de seguimiento', 'Primera consulta', 'Dolor abdominal',
            'Control de presión', 'Revisión de resultados', 'Vacunación'
        ];

        $count = 0;
        $fecha = now()->subMonths(6);

        while ($count < 3000) {
            foreach ($doctores as $doctor) {
                if ($count >= 3000) break;

                $paciente = $pacientes->random();
                $estado = $estados[array_rand($estados)];
                $hora = sprintf('%02d:00', rand(9, 16));
                $duracion = $doctor->especialidad->duracion_consulta;
                $hora_fin = date('H:i', strtotime($hora . ' + ' . $duracion . ' minutes'));

                $cita = Cita::create([
                    'doctor_id'           => $doctor->id,
                    'user_id'             => $paciente->id,
                    'fecha'               => $fecha->format('Y-m-d'),
                    'hora_inicio'         => $hora,
                    'hora_fin'            => $hora_fin,
                    'estado'              => $estado,
                    'motivo'              => $motivos[array_rand($motivos)],
                    'recordatorio_enviado'=> rand(0, 1),
                ]);

                // Si está completada crear consulta
                if ($estado === 'completada') {
                    Consulta::create([
                        'cita_id'          => $cita->id,
                        'peso'             => rand(50, 100) + (rand(0, 9) / 10),
                        'talla'            => rand(150, 190) + (rand(0, 9) / 10),
                        'presion_arterial' => rand(110, 140) . '/' . rand(70, 90),
                        'sintomas'         => $motivos[array_rand($motivos)],
                        'diagnostico'      => 'Diagnóstico de prueba generado automáticamente',
                        'receta'           => 'Paracetamol 500mg cada 8 horas por 3 días',
                        'notas_pendientes' => rand(0, 1) ? 'Regresar en 2 semanas' : null,
                    ]);
                }

                $count++;
                $fecha->addDays(rand(1, 3));
            }
        }
    }
}