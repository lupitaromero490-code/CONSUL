<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

   protected $fillable = [
    'name',
    'email',
    'password',
    'rol',
    'telefono',
    'fecha_nacimiento',
    'direccion',
    'alergias',
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relaciones
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    // Verificar rol
    public function esAdmin()
    {
        return $this->rol === 'admin';
    }

    public function esDoctor()
    {
        return $this->rol === 'doctor';
    }

    public function esPaciente()
    {
        return $this->rol === 'paciente';
    }
}