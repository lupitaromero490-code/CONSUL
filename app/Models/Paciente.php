<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'correo'
    ];

    // Relacion con turnos
    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }

    // Consulta paciente por nombre
    public function consulta($nombre)
    {
        return self::where('nombre', 'like', '%'.$nombre.'%')->get();
    }

    // Modificar datos del paciente
    public function modificar($datos)
    {
        $this->nombre = $datos['nombre'];
        $this->apellido = $datos['apellido'];
        $this->telefono = $datos['telefono'];
        $this->correo = $datos['correo'];
        $this->save();
    }
}