<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $fillable = [
        'numero_turno',
        'paciente_id',
        'servicio_id',
        'ventanilla_id',
        'estado',
        'hora_registro',
        'hora_llamada',
        'hora_fin'
    ];

    // Relacion con paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Relacion con servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    // Relacion con ventanilla
    public function ventanilla()
    {
        return $this->belongsTo(Ventanilla::class);
    }

    // Consulta turnos en espera
    public function consulta()
    {
        return self::where('estado', 'esperando')
                   ->orderBy('numero_turno')
                   ->get();
    }

    // Modificar estado del turno
    public function modificar($estado)
    {
        $this->estado = $estado;
        if($estado == 'en_atencion'){
            $this->hora_llamada = now();
        }
        if($estado == 'completado' || $estado == 'ausente'){
            $this->hora_fin = now();
        }
        $this->save();
    }
}