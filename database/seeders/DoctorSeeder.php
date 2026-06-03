<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Horario;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctores = [
            ['nombre' => 'Dr. Roberto Sánchez', 'email' => 'roberto@consul.com', 'especialidad_id' => 1, 'cedula' => 'CED001'],
            ['nombre' => 'Dra. Patricia Morales', 'email' => 'patricia@consul.com', 'especialidad_id' => 2, 'cedula' => 'CED002'],
            ['nombre' => 'Dr. Fernando Ruiz', 'email' => 'fernando@consul.com', 'especialidad_id' => 3, 'cedula' => 'CED003'],
            ['nombre' => 'Dra. Sofía Castro', 'email' => 'sofia@consul.com', 'especialidad_id' => 4, 'cedula' => 'CED004'],
            ['nombre' => 'Dr. Miguel Torres', 'email' => 'miguel@consul.com', 'especialidad_id' => 5, 'cedula' => 'CED005'],
            ['nombre' => 'Dra. Elena Vargas', 'email' => 'elena@consul.com', 'especialidad_id' => 6, 'cedula' => 'CED006'],
            ['nombre' => 'Dr. Alejandro Díaz', 'email' => 'alejandro@consul.com', 'especialidad_id' => 7, 'cedula' => 'CED007'],
            ['nombre' => 'Dra. Carmen Flores', 'email' => 'carmen@consul.com', 'especialidad_id' => 8, 'cedula' => 'CED008'],
            ['nombre' => 'Dr. Héctor Ramírez', 'email' => 'hector@consul.com', 'especialidad_id' => 9, 'cedula' => 'CED009'],
            ['nombre' => 'Dra. Valeria Mendoza', 'email' => 'valeria@consul.com', 'especialidad_id' => 10, 'cedula' => 'CED010'],
        ];

        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];

        foreach ($doctores as $d) {
            $user = User::create([
                'name'     => $d['nombre'],
                'email'    => $d['email'],
                'password' => Hash::make('doctor1234'),
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