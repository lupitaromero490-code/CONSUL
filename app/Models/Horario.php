<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = [
        'doctor_id',
        'dia',
        'hora_inicio',
        'hora_fin',
        'margen_minutos',
        'activo'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function consulta($doctor_id)
    {
        return self::where('doctor_id', $doctor_id)
                   ->where('activo', true)->get();
    }
}