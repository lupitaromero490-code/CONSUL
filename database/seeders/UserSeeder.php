<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Administrador CONSUL',
            'email'    => 'admin@consul.com',
            'password' => Hash::make('admin1234'),
            'rol'      => 'admin',
        ]);

        // Pacientes de prueba
        $pacientes = [
            ['María González', 'maria@gmail.com'],
            ['Juan Pérez', 'juan@gmail.com'],
            ['Ana Martínez', 'ana@gmail.com'],
            ['Carlos López', 'carlos@gmail.com'],
            ['Laura Hernández', 'laura@gmail.com'],
        ];

        foreach ($pacientes as $p) {
            User::create([
                'name'     => $p[0],
                'email'    => $p[1],
                'password' => Hash::make('paciente1234'),
                'rol'      => 'paciente',
            ]);
        }
    }
}