<?php

namespace Database\Seeders;

use App\Models\Especialidad;
use Illuminate\Database\Seeder;

class EspecialidadSeeder extends Seeder
{
    public function run(): void
    {
        $especialidades = [
            ['nombre' => 'Medicina General', 'descripcion' => 'Atención médica general', 'duracion_consulta' => 30],
            ['nombre' => 'Pediatría', 'descripcion' => 'Atención médica para niños', 'duracion_consulta' => 45],
            ['nombre' => 'Cardiología', 'descripcion' => 'Enfermedades del corazón', 'duracion_consulta' => 60],
            ['nombre' => 'Dermatología', 'descripcion' => 'Enfermedades de la piel', 'duracion_consulta' => 30],
            ['nombre' => 'Ginecología', 'descripcion' => 'Salud femenina', 'duracion_consulta' => 45],
            ['nombre' => 'Odontología', 'descripcion' => 'Salud dental', 'duracion_consulta' => 60],
            ['nombre' => 'Oftalmología', 'descripcion' => 'Enfermedades de los ojos', 'duracion_consulta' => 30],
            ['nombre' => 'Ortopedia', 'descripcion' => 'Huesos y articulaciones', 'duracion_consulta' => 60],
            ['nombre' => 'Neurología', 'descripcion' => 'Sistema nervioso', 'duracion_consulta' => 60],
            ['nombre' => 'Psiquiatría', 'descripcion' => 'Salud mental', 'duracion_consulta' => 60],
        ];

        foreach ($especialidades as $e) {
            Especialidad::create([
                'nombre'            => $e['nombre'],
                'descripcion'       => $e['descripcion'],
                'duracion_consulta' => $e['duracion_consulta'],
                'activo'            => true,
            ]);
        }
    }
}