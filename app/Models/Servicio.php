<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'duracion_promedio',
        'activo'
    ];

    // Relacion con turnos
    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }

    // Consulta servicios activos
    public function consulta()
    {
        return self::where('activo', true)->get();
    }
}