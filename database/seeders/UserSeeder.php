<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $adminPassword = env('ADMIN_PASSWORD') ?: Str::random(16);

        User::create([
            'name'     => 'Administrador CONSUL',
            'email'    => env('ADMIN_EMAIL', 'admin@example.com'),
            'password' => Hash::make($adminPassword),
            'rol'      => 'admin',
        ]);

        if (! env('ADMIN_PASSWORD')) {
            $this->command->info("Contraseña del admin generada: {$adminPassword}");
        }

        // Pacientes de prueba
        $pacientes = [
            ['María González', 'maria@example.com'],
            ['Juan Pérez', 'juan@example.com'],
            ['Ana Martínez', 'ana@example.com'],
            ['Carlos López', 'carlos@example.com'],
            ['Laura Hernández', 'laura@example.com'],
        ];

        foreach ($pacientes as $p) {
            User::create([
                'name'     => $p[0],
                'email'    => $p[1],
                'password' => Hash::make(Str::random(16)),
                'rol'      => 'paciente',
            ]);
        }
    }
}
