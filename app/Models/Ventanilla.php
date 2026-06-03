<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ventanilla extends Model
{
    protected $fillable = [
        'nombre',
        'numero',
        'estado',
        'user_id'
    ];

    // Relacion con usuario operador
    public function operador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relacion con turnos
    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }

    // Consulta ventanillas activas
    public function consulta()
    {
        return self::where('estado', 'activa')->get();
    }
}