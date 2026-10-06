<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Horario;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctores = [
    ['nombre' => 'Dr. Roberto Sánchez', 'email' => 'roberto@example.com', 'especialidad_id' => 1, 'cedula' => 'CED001'],
    ['nombre' => 'Dra. Patricia Morales', 'email' => 'patricia@example.com', 'especialidad_id' => 2, 'cedula' => 'CED002'],
    ['nombre' => 'Dr. Fernando Ruiz', 'email' => 'fernando@example.com', 'especialidad_id' => 3, 'cedula' => 'CED003'],
    ['nombre' => 'Dra. Sofía Castro', 'email' => 'sofia@example.com', 'especialidad_id' => 4, 'cedula' => 'CED004'],
    ['nombre' => 'Dr. Miguel Torres', 'email' => 'miguel@example.com', 'especialidad_id' => 5, 'cedula' => 'CED005'],
    ['nombre' => 'Dra. Elena Vargas', 'email' => 'elena@example.com', 'especialidad_id' => 6, 'cedula' => 'CED006'],
    ['nombre' => 'Dr. Alejandro Díaz', 'email' => 'alejandro@example.com', 'especialidad_id' => 7, 'cedula' => 'CED007'],
    ['nombre' => 'Dra. Carmen Flores', 'email' => 'carmen@example.com', 'especialidad_id' => 8, 'cedula' => 'CED008'],
    ['nombre' => 'Dr. Héctor Ramírez', 'email' => 'hector@example.com', 'especialidad_id' => 9, 'cedula' => 'CED009'],
    ['nombre' => 'Dra. Valeria Mendoza', 'email' => 'valeria@example.com', 'especialidad_id' => 10, 'cedula' => 'CED010'],
];

        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];

        $doctorPassword = env('DOCTOR_PASSWORD') ?: Str::random(16);

if (! env('DOCTOR_PASSWORD')) {
    $this->command->info("Contraseña de los doctores generada: {$doctorPassword}");
}
        
        foreach ($doctores as $d) {
            $user = User::create([
                'name'     => $d['nombre'],
                'email'    => $d['email'],
                'password' => Hash::make($doctorPassword),
                'rol'      => 'doctor',
            ]);

            $doctor = Doctor::create([
                'user_id'         => $user->id,
                'especialidad_id' => $d['especialidad_id'],
                'cedula'          => $d['cedula'],
                'telefono'        => '4431' . rand(100000, 999999),
                'celular'         => '4431' . rand(100000, 999999),
                'descripcion'     => 'Médico especialista con amplia experiencia',
                'activo'          => true,
            ]);

            // Crear horarios para cada día
            foreach ($dias as $dia) {
                Horario::create([
                    'doctor_id'      => $doctor->id,
                    'dia'            => $dia,
                    'hora_inicio'    => '09:00',
                    'hora_fin'       => '17:00',
                    'margen_minutos' => 15,
                    'activo'         => true,
                ]);
            }
        }
    }
}
