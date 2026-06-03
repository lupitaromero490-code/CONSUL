<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = [
        'doctor_id',
        'user_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado',
        'motivo',
        'recordatorio_enviado'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function paciente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function consulta()
    {
        return $this->hasOne(Consulta::class);
    }

    public function consultasPendientes()
    {
        return self::where('estado', 'pendiente')
                   ->orderBy('fecha')->get();
    }

    public function modificar($estado)
    {
        $this->estado = $estado;
        $this->save();
    }
}